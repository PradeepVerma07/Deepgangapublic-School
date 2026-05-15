<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Menu;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Exception;

class MenuController extends MainController
{
    public function index(Request $request)
    {
        $query = Menu::with('children')->where('parent', 0);
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
        $query->orderBy('seq', 'asc');
        $menus = $query->paginate(10);
        $menus->appends($request->only(['search', 'date_range', 'status', 'sort_by']));

        $title = 'Menus';
        $page = 'admin.menus.index';
        return $this->template($page, compact('menus', 'title'));
    }

    public function create()
    {
        $title = 'Create Menu';
        $comp = 'menu';
        $menus = Menu::where('parent', 0)->get();
        return $this->template('admin.menus.create', compact('title', 'menus', 'comp'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent' => 'nullable|exists:admin_menus,id',
            'description' => 'nullable|string',
            'seq' => 'required|integer',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a menu.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'url' => $request->input('url'),
                'icon' => $request->input('icon'),
                'parent' => $request->input('parent') ?: 0,
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
            ];

            Menu::create($data);
            Toastr::success('Menu created successfully.', 'Success');
            return redirect()->route('admin.menus.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create menu: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(Menu $menu)
    {
        $title = 'Edit Menu';
        $comp = 'menu';
        $menus = Menu::where('parent', 0)->where('id', '!=', $menu->id)->get();
        return $this->template('admin.menus.edit', compact('menu', 'title', 'menus', 'comp'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'parent' => 'nullable|exists:admin_menus,id',
            'description' => 'nullable|string',
            'seq' => 'required|integer',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);
        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a menu.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'title' => $request->input('title'),
                'url' => $request->input('url'),
                'icon' => $request->input('icon'),
                'parent' => $request->input('parent') ?: 0,
                'description' => $request->input('description'),
                'seq' => $request->input('seq'),
            ];

            $menu->update($data);
            Toastr::success('Menu updated successfully.', 'Success');
            return redirect()->route('admin.menus.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update menu: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(Menu $menu)
    {
        try {
            $menu->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'Menu deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete menu: ' . $e->getMessage(),
            ]);
        }
    }
}
