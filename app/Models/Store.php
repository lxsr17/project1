<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    // ربط الموديل بجدول businesses بدل stores
    protected $table = 'businesses';

    protected $fillable = [
        'store_owner_id',
        'business_name',
        'business_type',
        'description',
        'logo',
        'rating',
        'rating_count',
        'return_policy',
        'no_return_allowed',
        'return_days',
        'exchange_days',
        'twitter',
        'instagram',
        'tiktok',
        'website',
        'android_app',
        'ios_app',
        'whatsapp',
        'telegram'
    ];
}
