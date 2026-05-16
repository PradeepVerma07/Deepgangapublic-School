<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('contact-us');
Route::post('/contact-us-submit', [HomeController::class, 'contactSubmit'])->name('contact-us-submit');
Route::get('/about-us', [HomeController::class, 'about'])->name('about-us');
Route::get('/gallery', [HomeController::class, 'gallery'])->name('gallery');
Route::get('/terms-conditions', [HomeController::class, 'termsConditions'])->name('terms-conditions');
Route::get('/privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/student-excellence', [HomeController::class, 'brandPartner'])->name('brand-partner');
Route::get('/admissions', [HomeController::class, 'training'])->name('training');
Route::get('/online-registration', [HomeController::class, 'membershipOffer'])->name('membership-offer');
Route::get('/academics', [HomeController::class, 'academy'])->name('academy');
Route::get('/academy', [HomeController::class, 'academy'])->name('academy.legacy');
Route::get('student-excellence/notice', [homeController::class, 'notices'])->name('notices');
Route::get('/our-services', [HomeController::class, 'ourServices'])->name('our-services');
Route::get('student-excellence/toppers', [HomeController::class, 'allToppers'])->name('all-toppers');
Route::get('/disclosure', [HomeController::class, 'disclosure'])->name('disclosure');
Route::get('/services-detail/{slug}', [HomeController::class, 'servicesDetail'])->name('services-detail');

///new
// Route::get('/', [HomeController::class, 'indexs'])->name('index');
// Route::get('/about', [HomeController::class, 'about'])->name('about');
// Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Route::get('/media', [HomeController::class, 'media'])->name('media');
//Route::get('/academics', [HomeController::class, 'academics'])->name('academics');
// Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
// Route::get('/media', [HomeController::class, 'media'])->name('media');
// Route::get('/application', [HomeController::class, 'application'])->name('application');
// Route::get('/addmission', [HomeController::class, 'addmission'])->name('addmission');
// Route::get('/how-to-apply', [HomeController::class, 'howtoapply'])->name('how.to.apply');
// Route::get('tuition-fee', [HomeController::class, 'tuitionfee'])->name('tuition.fee');
// Route::get('facilities', [HomeController::class, 'facilities'])->name('facilities');
// Route::get('excellence', [HomeController::class, 'excellence'])->name('excellence');
