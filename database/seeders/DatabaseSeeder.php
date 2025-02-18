<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Business;

class BusinessSeeder extends Seeder
{
    public function run()
    {
        Business::create([
            'name' => 'مطعم الطاهي الذهبي',
            'owner_name' => 'محمد أحمد',
            'email' => 'goldenchef@example.com',
            'phone' => '0555555555',
            'description' => 'مطعم يقدم أشهى المأكولات الشرقية والغربية.',
            'category' => 'مطاعم',
            'location' => 'الرياض'
        ]);

        Business::create([
            'name' => 'متجر التقنية الحديثة',
            'owner_name' => 'سامي العتيبي',
            'email' => 'techstore@example.com',
            'phone' => '0566666666',
            'description' => 'متجر متخصص في بيع الأجهزة الإلكترونية والإكسسوارات.',
            'category' => 'تقنية',
            'location' => 'جدة'
        ]);
    }
}
