<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Helpers\UploadImage;

class SettingsController extends MainController
{
    public function index()
    {
        $page = 'admin.settings';
        $title = 'Settings';
        $settings = Setting::all()->pluck('value', 'title')->toArray();
        return $this->template($page, compact('title', 'settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'pagination_settings' => 'required|integer|min:1',
            'imgs_url' => 'nullable|url',
            'default_image_path' => 'nullable|url',
            'upload_path' => 'nullable|string',
            'delete_path' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:500',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:500',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'logo' && $request->hasFile('logo')) {
                $upload = UploadImage::upload($request, 'logo', null, 'system', 500);
                if ($upload['res'] === 'error') {
                    return redirect()->back()->withInput()->with('error', 'Logo upload failed.');
                }
                $value = $upload['file_path'];
            } elseif ($key === 'favicon' && $request->hasFile('favicon')) {
                $upload = UploadImage::upload($request, 'favicon', null, 'system', 500);
                if ($upload['res'] === 'error') {
                    return redirect()->back()->withInput()->with('error', 'Favicon upload failed.');
                }
                $value = $upload['file_path'];
            }

            if ($key !== 'logo' && $key !== 'favicon' || ($key === 'logo' && $request->hasFile('logo')) || ($key === 'favicon' && $request->hasFile('favicon'))) {
                Setting::updateOrCreate(
                    ['title' => $key],
                    ['value' => $value]
                );
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
}
