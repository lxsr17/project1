<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_owner_id',
        'plan_name',
        'price',
        'start_date',
        'end_date',
        'status',
    ];
}
