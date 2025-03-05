<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'first_name' => 'أحمد',
                'last_name' => 'المالكي',
                'username' => 'ahmad99',
                'email' => 'ahmad@example.com',
                'password' => Hash::make('password123'),
                'birthdate' => '1997-02-20',
                'phone' => '0569876543',
                'sex' => 'Male',
                'city' => 'جدة',
                'state' => 'مكة',
                'street' => 'التحلية',
                'neighborhood' => 'السلامة',
                
            ],
            [
                'first_name' => 'سارة',
                'last_name' => 'العمري',
                'username' => 'sara88',
                'email' => 'sara@example.com',
                'password' => Hash::make('pass456'),
                'birthdate' => '1995-05-15',
                'phone' => '0551234567',
                'sex' => 'Female',
                'city' => 'الرياض',
                'state' => 'الرياض',
                'street' => 'الملك فهد',
                'neighborhood' => 'العليا',
                
            ],
            [
                'first_name' => 'محمد',
                'last_name' => 'الزهراني',
                'username' => 'mohd77',
                'email' => 'mohd@example.com',
                'password' => Hash::make('mypass789'),
                'birthdate' => '1990-11-10',
                'phone' => '0547891234',
                'sex' => 'Male',
                'city' => 'مكة',
                'state' => 'مكة',
                'street' => 'الحجون',
                'neighborhood' => 'الزاهر',
                
            ],
        ];

        // Insert all users into the database
        DB::table('users')->insert($users);
    }
}