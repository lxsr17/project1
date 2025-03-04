<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // إذا كان اسم الجدول مختلفًا، يمكن تحديده هنا:
    // protected $table = 'اسم_الجدول';

    // تحديد الأعمدة القابلة للتعديل (mass assignable)
    protected $fillable = [
        'first_name', 'last_name', 'username', 'email', 'password', 'birthdate', 'phone', 'sex', 'address', 'street', 'neighborhood', 'city', 'state'
    ];
}
