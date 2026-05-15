<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MainController;
use App\Models\WebsiteMenu;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Str;
use Exception;
use Illuminate\Support\Facades\Log;

class WebsiteMenuController extends MainController
{
    public function index(Request $request)
    {
        $query = WebsiteMenu::query()->with('parent');
        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
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
        $menus->appends($request->only(['search', 'date_range', 'status']));

        $title = 'Website Menus';
        $page = 'admin.website-menus.index';
        return $this->template($page, compact('menus', 'title'));
    }

    public function create()
    {
        $title = 'Create Website Menu';
        $comp = 'website-menu';
        $parents = WebsiteMenu::whereNull('parent_id')->where('active', 1)->orderBy('title')->get();
        return $this->template('admin.website-menus.create', compact('title', 'comp', 'parents'));
    }

    public function store(Request $request)
    {
        $user = $this->userData();
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:website_menus,id',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to create a menu.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            WebsiteMenu::create([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title')),
                'parent_id' => $request->input('parent_id'),
                'seq' => $request->input('seq'),
                'school_id' =>$user->school_id,
                'active' => 1,
            ]);
            Toastr::success('Website menu created successfully.', 'Success');
            return redirect()->route('admin.website-menus.index');
        } catch (Exception $e) {
            Toastr::error('Failed to create website menu: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function edit(WebsiteMenu $websiteMenu)
    {
        $title = 'Edit Website Menu';
        $comp = 'website-menu';
        $parents = WebsiteMenu::whereNull('parent_id')->where('active', 1)->where('id', '!=', $websiteMenu->id)->orderBy('title')->get();
        return $this->template('admin.website-menus.edit', compact('websiteMenu', 'title', 'comp', 'parents'));
    }

    public function update(Request $request, WebsiteMenu $websiteMenu)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:website_menus,id',
            'seq' => 'required|integer|min:0',
            'permissions' => 'required|array',
            'permissions.add_update' => 'required|in:1',
        ]);

        if (!$request->input('permissions.add_update') == 1) {
            Toastr::error('You do not have permission to update a menu.', 'Error');
            return redirect()->back()->withInput();
        }

        try {
            $websiteMenu->update([
                'title' => $request->input('title'),
                'slug' => Str::slug($request->input('title')),
                'parent_id' => $request->input('parent_id'),
                'seq' => $request->input('seq'),
            ]);
            Toastr::success('Website menu updated successfully.', 'Success');
            return redirect()->route('admin.website-menus.index');
        } catch (Exception $e) {
            Toastr::error('Failed to update website menu: ' . $e->getMessage(), 'Error');
            return redirect()->back()->withInput();
        }
    }

    public function destroy(WebsiteMenu $websiteMenu)
    {
        try {
            $websiteMenu->delete();
            Toastr::success('Website menu deleted successfully.', 'Success');
            return redirect()->route('admin.website-menus.index');
        } catch (Exception $e) {
            Toastr::error('Failed to delete website menu: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
}
