<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Tips & Trik', 'Tren Arsitektur', 'Berita Perusahaan'];

        foreach ($categories as $category) {
            NewsCategory::firstOrCreate(
                ['name' => $category],
                [
                    'id' => Str::uuid(),
                    'slug' => Str::slug($category),
                    'description' => 'Kumpulan artikel seputar ' . $category,
                ]
            );
        }
    }
}
