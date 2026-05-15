<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Helpers\UploadImage;

class ProfileController extends MainController
{
    public function index()
    {
        $page = 'admin.profile';
        $title = 'Admin Profile';
        return $this->template($page, compact('title'));
    }
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'mobile' => 'required|digits_between:10,15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'nullable|string|max:255',
            'map_link' => 'nullable|url',
            'pincode' => 'nullable|digits_between:5,10',
            'mobile2' => 'nullable|digits_between:10,15',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'whatsapp_no' => 'nullable|digits_between:10,15',
        ]);
        $user = Auth::user();
        if ($request->hasFile('photo')) {
            $upload = UploadImage::upload($request, 'photo', null, 'users', 500);
            if ($upload['res'] === 'error') {
                return redirect()->back()->withInput();
            }
            $validated['photo'] = $upload['file_path'];
        }
        $user->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['password' => 'Current password is incorrect.']);
        }
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->back()->with('success', 'Password changed successfully.');
    }
}
