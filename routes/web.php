<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessController;

// الراوت الأساسي لعرض الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome'); // يعرض welcome.blade.php
});

// عرض قائمة الأنشطة التجارية
Route::resource('businesses', BusinessController::class);



