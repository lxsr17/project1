<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessController;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome'); 
});

// صفحة تسجيل الدخول
Route::get('/login', function () {
    return view('auth.login'); // تأكد أن الملف موجود في resources/views/auth/login.blade.php
});

// عرض قائمة الأنشطة التجارية
Route::resource('businesses', BusinessController::class);



