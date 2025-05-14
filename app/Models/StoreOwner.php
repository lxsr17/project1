<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StoreOwner extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $table = 'store_owners';


    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'birthdate',
        'phone',
        'sex',
        'city',
        'state',
        'street',
        'neighborhood',
        'status',  // ✅ إضافة الحالة ضمن الخصائص المسموحة
    ];
    
    
    
    protected $hidden = [
        'password',
    ];
}
