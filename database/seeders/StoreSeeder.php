<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::create([
            'store_owner_id' => 1,
            'businessNameAr' => 'متجر تحقق',
            'businessNameEn' => 'Tahaqaq Store',
            'mainCategory' => 'fashion',
            'subCategory' => 'women',
            'customSubCategory' => null,
            'businessDescription' => 'هذا متجر تم إنشاؤه للتجربة',
            'logo' => 'https://via.placeholder.com/80',
            'rating' => 4.7,
            'ratingCount' => 23
        ]);
    }
}
