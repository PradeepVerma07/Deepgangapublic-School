<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\GalleryCategoryController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\LatestNewsController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\TopperController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AdmissionRequestController;
use App\Http\Controllers\Admin\WebsiteMenuController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\BrandPartnerController;
use App\Http\Controllers\Admin\MembershipOfferController;
use App\Http\Controllers\Admin\ServiceController;



Route::middleware('admin.guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::middleware(['admin.auth'])->group(function () {
    Route::post('/select-school', [LoginController::class, 'selectSchool'])->name('select.school');
    Route::post('change_status', [MainController::class, 'changeStatus'])->name('change_status');
    Route::post('change_indexing', [MainController::class, 'changeIndexing'])->name('change_indexing');
});

Route::middleware(['admin.auth', 'role.menu.access'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('menus', MenuController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::get('roles/{role}/menu-access', [RoleController::class, 'menuAccess'])->name('roles.menu_access');
    Route::post('roles/{role}/menu-access', [RoleController::class, 'saveMenuAccess'])->name('roles.menu_access.save');
    Route::resource('gallery-categories', GalleryCategoryController::class);
    Route::resource('gallery', GalleryController::class);
    Route::resource('banners',  BannerController::class);
    Route::resource('testimonials', TestimonialController::class);
    Route::resource('messages', MessageController::class);
    Route::resource('latest-news', LatestNewsController::class);
    Route::resource('classes', ClassController::class);
    Route::resource('toppers', TopperController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('students', StudentController::class);
    Route::get('admission-requests', [AdmissionRequestController::class, 'index'])->name('admission-requests.index');
    Route::resource('website-menus', WebsiteMenuController::class);
    Route::resource('sections', SectionController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('brand-partners', BrandPartnerController::class);
    Route::resource('membership-offers',MembershipOfferController::class);
    Route::resource('services', ServiceController::class);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change_password');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');

});
