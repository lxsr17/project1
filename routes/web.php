<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome'); 
})->name('welcome'); 

// صفحة تسجيل الدخول
Route::get('/login1', function () {
    return view('auth.login1'); 
})->name('login1'); 



Route::get('/login', function () {
    return view('login1'); // بدون .blade.php
});

use App\Http\Controllers\UsersController;

Route::get('/users', [UsersController::class, 'index'])->name('users.index');  // عرض كل المستخدمين
Route::get('/users/{id}', [UsersController::class, 'show'])->name('users.show');    // عرض مستخدم واحد
Route::post('/users', [UsersController::class, 'store'])->name('users.store');       // إنشاء مستخدم جديد
Route::put('/users/{id}', [UsersController::class, 'update'])->name('users.update');  // تحديث بيانات المستخدم
Route::delete('/users/{id}', [UsersController::class, 'destroy'])->name('users.destroy'); // حذف المستخدم
