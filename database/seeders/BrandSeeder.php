<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Phish & Giggles',
            'Scamazon Prime',
            'Ponzi & Co.',
            'ClickBait Couture',
            'FraudHub Labs',
            'Nigerian Prince LLC',
            'CryptoKlepto',
            'Spamurai',
            'Bogus & Sons',
            'Deceivify',
        ];

        foreach ($brands as $name) {
            Brand::updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }
    }
}


