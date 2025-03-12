<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\StoreOwnerController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|


Route::get('/', function () {
    return view('index'); // يعرض index.blade.php
})->name('home');
*/

route::get('/', function () {
    return view('main.index'); 
})->name('index');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ✅  إضافة مسارات التسجيل زائر */
Route::get('/register', function () {
    return view('auth.register'); // يعرض صفحة التسجيل
})->name('register');

/* ✅  إضافة مسارات التسجيل التاجر */
Route::get('/merchant-register', function () {
    return view('auth.merchant-register'); // يعرض صفحة التسجيل
})->name('merchant-register');
Route::get('/merchant-register', [StoreOwnerController::class, 'create'])->name('merchant.register');
Route::post('/merchant-register', [StoreOwnerController::class, 'store'])->name('merchant.store');

/* ✅  تسجيل الدخول*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

/* ✅  المتاجر */
Route::get('/stores', function () {
    return view('main.stores'); // يعرض صفحة التسجيل
})->name('stores');
/* ✅تواصل معنا  */
Route::get('/contact', function () {
    return view('main.contact'); // يعرض صفحة التسجيل
})->name('contact');

Route::get('/merchant-dashboard', function () {
    return view('main.merchant-dashboard'); // يعرض صفحة التاجر 
})->name('merchant-dashboard');


Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

require __DIR__.'/auth.php';
 