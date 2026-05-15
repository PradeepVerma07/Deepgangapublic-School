<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckRoleMenuAccess
{
    public function handle(Request $request, Closure $next)
    {
        $url = explode('/', $request->path())[1];

        if ($url === 'dashboard') {
            $request->merge([
                'permissions' => [
                    'add_update' => 0,
                    'trash' => 0,
                    'view' => 1
                ]
            ]);
            return $next($request);
        }

        $permission = DB::table('admin_menus')
            ->where('url', $url)
            ->where('active', 1)
            ->first();

        if (!$permission) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('error', 'Menu not found or inactive.');
        }

        $user = Auth::user();
        if (!$user) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('error', 'Please log in to access this page.');
        }

        if (!$user->role_id) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('error', 'User role not assigned.');
        }

        $role = DB::table('admin_roles')
            ->where('id', $user->role_id)
            ->where('active', 1)
            ->first();

        if (!$role) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('error', 'Role not found or inactive.');
        }

        $role_permission = DB::table('admin_role_menus')
            ->where('role_id', $role->id)
            ->where('menu_id', $permission->id)
            ->first();

        if (!$role_permission || $role_permission->view == 0) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('error', 'You do not have permission to access this page.');
        }

        $request->merge([
            'permissions' => [
                'add_update' => $role_permission->add_update,
                'trash' => $role_permission->trash,
                'view' => $role_permission->view
            ]
        ]);

        return $next($request);
    }
}
