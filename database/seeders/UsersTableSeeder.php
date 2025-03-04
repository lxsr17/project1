<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'أحمد',
            'last_name' => 'المالكي',
            'username' => 'ahmad99',
            'email' => 'ahmad@example.com',
            'password' => Hash::make('password123'),
            'birthdate' => '1997-02-20',
            'phone' => '0569876543',
            'sex' => 'Male',
            'address' => 'جدة، السعودية',
            'city' => 'جدة',
            'state' => 'مكة',
            'street' => 'التحلية',
            'neighborhood' => 'السلامة',
        ]);
    }
}
