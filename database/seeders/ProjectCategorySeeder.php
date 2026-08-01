<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Residensial',
            'Komersial',
            'Interior',
            'Lanskap'
        ];

        foreach ($categories as $category) {
            ProjectCategory::firstOrCreate(
                ['name' => $category],
                [
                    'id' => Str::uuid(),
                    'slug' => Str::slug($category),
                    'description' => 'Kategori untuk proyek ' . $category,
                ]
            );
        }
    }
}
