<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_owner_id',
        'business_name',
        'business_type',
        'description',
        'status',
        'logo',
        'freelancer_document',
        'commercial_registration_document',
        'link_type',
        'return_policy',
        'no_return_allowed',
        'return_days',
        'exchange_days',
        'twitter',
        'show_twitter',
        'instagram',
        'show_instagram',
        'tiktok',
        'show_tiktok',
        'website',
        'android_app',
        'ios_app',
        'whatsapp',
        'telegram',
        'phone1',
        'phone2',
        'email',
        'city',
        'address',
    ];

    public function storeOwner()
    {
        return $this->belongsTo(StoreOwner::class, 'store_owner_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'store_id');
    }
}
