<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use App\Helpers\UploadImage;
use Illuminate\Support\Facades\Hash;

class UserController extends MainController
{
    public function index(Request $request)
    {
        $query = User::with('role');
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('mobile', 'like', "%{$search}%");
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
        $users = $query->paginate(10);
        $users->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Users';
        $page = 'admin.users.index';
        return $this->template($page, compact('users', 'title'));
    }

    public function create()
    {
        $title = 'Create User';
        $comp = 'user';
        $roles = Role::where('active', 1)->get();
        return $this->template('admin.users.create', compact('title', 'roles', 'comp'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'mobile' => 'nullable|string|max:15',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'role_id' => 'required|exists:admin_roles,id',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a user.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'mobile' => $request->input('mobile'),
                'role_id' => $request->input('role_id'),
                'active' => 1,
            ];

            if ($request->hasFile('photo')) {
                $upload = UploadImage::upload($request, 'photo', null, 'users', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['photo'] = $upload['file_path'];
            }

            User::create($data);
            Toastr::success('User created successfully.', 'Success');
            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create user: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(User $user)
    {
        $title = 'Edit User';
        $comp = 'user';
        $roles = Role::where('active', 1)->get();
        return $this->template('admin.users.edit', compact('user', 'title', 'roles', 'comp'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:15',
            'photo' => 'nullable|file|mimes:jpg,jpeg,png,svg,avif,webp|max:500',
            'role_id' => 'required|exists:admin_roles,id',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a user.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $data = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'mobile' => $request->input('mobile'),
                'role_id' => $request->input('role_id'),
            ];

            if ($request->hasFile('photo')) {
                $upload = UploadImage::upload($request, 'photo', $user->photo, 'users', 500);
                if ($upload['res'] === 'error') {
                    Toastr::error($upload['msg'], 'Error');
                    return redirect()->back()->withInput();
                }
                $data['photo'] = $upload['file_path'];
            }

            $user->update($data);
            Toastr::success('User updated successfully.', 'Success');
            return redirect()->route('admin.users.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update user: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(User $user)
    {
        try {
            if ($user->photo && $user->photo !== config('app.DEFAULT_IMAGE') . 'avatar-4.jpg') {
                UploadImage::deleteFile($user->photo);
            }
            $user->delete();
            return response()->json([
                'res' => 'success',
                'msg' => 'User deleted successfully.',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'res' => 'error',
                'msg' => 'Failed to delete user: ' . $e->getMessage(),
            ]);
        }
    }
}
