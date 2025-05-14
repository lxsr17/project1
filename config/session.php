<?php

use Illuminate\Support\Str;

return [

    'driver' => env('SESSION_DRIVER', 'file'),

    'lifetime' => env('SESSION_LIFETIME', 10),

    'expire_on_close' => true,

    'encrypt' => false,

    'files' => storage_path('framework/sessions'),

    'connection' => env('SESSION_CONNECTION'),

    'table' => 'sessions',

    'store' => env('SESSION_STORE'),

    'lottery' => [2, 100],

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_') . '_session'
    ),

    'path' => '/',

    // ❗️تأكد أنها null مباشرة بدون env()
    'domain' => null,

    'secure' => env('SESSION_SECURE_COOKIE', false),

    'http_only' => true,

    'same_site' => 'lax',

];
