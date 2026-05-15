<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Role;
use App\Models\Menu;
use App\Models\RoleMenu;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Log;

class RoleController extends MainController
{
    public function index(Request $request)
    {
        $query = Role::query();
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        if ($dateRange = $request->input('date_range')) {
            $dates = explode(' - ', $dateRange);
            if (count($dates) === 2) {
                $startDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]))->startOfDay();
                $endDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }
        }
        if ($request->has('status')) {
            $status = $request->input('status');
            $query->where('active', $status);
        }
        $query->orderBy('id', 'asc');
        $roles = $query->paginate(10);
        $roles->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Roles';
        $page = 'admin.roles.index';
        return $this->template($page, compact('roles', 'title'));
    }

    public function create()
    {
        $title = 'Create Role';
        $comp = 'role';
        return $this->template('admin.roles.create', compact('title', 'comp'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:admin_roles,title',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a role.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'active' => 1,
            ];

            Role::create($data);
            Log::info('Role created: ' . $request->input('title'), ['user_id' => auth()->id()]);
            Toastr::success('Role created successfully.', 'Success');
            return redirect()->route('roles.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create role: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Role $role)
    {
        $title = 'Edit Role';
        $comp = 'role';
        return $this->template('admin.roles.edit', compact('role', 'title', 'comp'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:admin_roles,title,' . $role->id,
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a role.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'description' => $request->input('description'),
            ];

            $role->update($data);
            Log::info('Role updated: ' . $request->input('title'), ['user_id' => auth()->id()]);
            Toastr::success('Role updated successfully.', 'Success');
            return redirect()->route('roles.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update role: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Role $role)
    {
        try {
            $role->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Role deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete role: ' . $e->getMessage(),
            ]);
        }
    }

    public function menuAccess(Role $role)
    {
        $title = 'Menu Access - ' . $role->title;
        $comp = 'role';
        $menus = Menu::with('children')->where('parent', 0)->get();
        $permissions = RoleMenu::where('role_id', $role->id)->get()->keyBy('menu_id');

        return $this->template('admin.roles.menu_access', compact('title', 'comp', 'menus', 'role', 'permissions'));
    }

    public function saveMenuAccess(Request $request, Role $role)
    {
        $request->validate([
            'm_id' => 'required|exists:admin_menus,id',
            'type' => 'required|in:set,remove',
            'name' => 'nullable|in:add_update,trash,view,',
        ]);

        try {
            $menuId = $request->input('m_id');
            $type = $request->input('type');
            $name = $request->input('name', '');
            $value = $type === 'set' ? 1 : 0;
            $check = ['role_id' => $role->id, 'menu_id' => $menuId];
            $menu = Menu::findOrFail($menuId);

            if ($name == '') {
                if ($type == 'set') {
                    $data = ['add_update' => $value, 'trash' => $value, 'view' => $value];
                    $existing = RoleMenu::where($check)->first();
                    if ($existing) {
                        $existing->update($data);
                    } else {
                        $check['add_update'] = $value;
                        $check['trash'] = $value;
                        $check['view'] = $value;
                        RoleMenu::create($check);
                    }
                } else {
                    RoleMenu::where($check)->delete();
                }
            } else {
                $data = [$name => $value];
                $existing = RoleMenu::where($check)->first();
                if ($existing) {
                    $existing->update($data);
                } else {
                    if ($type === 'set') {
                        $check[$name] = $value;
                        RoleMenu::create($check);
                    } else {
                        return response()->json(['res' => 'error', 'msg' => 'Menu not assigned!']);
                    }
                }
            }

            return response()->json(['res' => 'success', 'msg' => 'Saved.']);
        } catch (Exception $e) {
            return response()->json(['res' => 'error', 'msg' => 'Failed to save permissions: ' . $e->getMessage()]);
        }
    }
}
