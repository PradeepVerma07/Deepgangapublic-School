<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        $title = 'Administrator Login';
        $comp = getSetting('app_name');
        $schools = User::where('role_id', 2)->get();
        return view('admin.auth.login', compact('title', 'comp', 'schools'));
    }

    public function login(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
        }

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role_id == 2) {
                $request->session()->regenerate();
                $user->school_id = $user->id;
                $user->save();
                return response()->json([
                    'status' => 'success',
                    'redirect' => route('admin.dashboard')
                ]);
            } elseif ($user->role_id == 1) {
                $schools = User::where('role_id', 2)->get(['id', 'name'])->toArray();
                return response()->json([
                    'status' => 'school_selection',
                    'schools' => $schools
                ]);
            } else {
                Auth::logout();
                return response()->json([
                    'status' => 'error',
                    'message' => 'You do not have access to this system.'
                ], 403);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials'
        ], 401);
    }

    public function selectSchool(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
        }

        $request->validate([
            'school_id' => 'required|exists:users,id,role_id,2'
        ]);

        $user = Auth::user();
        if (!$user || $user->role_id != 1) {
            Auth::logout();
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized action'
            ], 403);
        }

        $user->school_id = $request->school_id;
        $user->save();
        $request->session()->regenerate();

        return response()->json([
            'status' => 'success',
            'redirect' => route('admin.dashboard')
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
