<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in to access this page.');
        }

        $user = Auth::user();
        $active = DB::table('users')->where('id', $user->id)->value('active');
        if ($active == 0) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('error', 'Your account is inactive. Please contact the administrator.');
        }

        $restricted_roles = [1,2];
        if (!in_array($user->role_id, $restricted_roles)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('admin.login')->with('error', 'Unauthorized access. This role is not permitted.');
        }

        return $next($request);
    }
}
