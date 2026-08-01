<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ProjectCategory::all();

        if ($categories->isEmpty()) {
            return;
        }

        foreach ($categories as $category) {
            for ($i = 1; $i <= 2; $i++) {
                $title = "Proyek " . $category->name . " $i";
                Project::firstOrCreate(
                    ['title' => $title],
                    [
                        'id' => Str::uuid(),
                        'slug' => Str::slug($title),
                        'category_id' => $category->id,
                        'year' => rand(2020, 2024),
                        'location' => 'Jakarta',
                        'area' => rand(100, 1000) . ' m2',
                        'description' => 'Ini adalah deskripsi untuk proyek ' . $title . '. Proyek ini dirancang dengan gaya modern dan fungsional, memaksimalkan penggunaan cahaya alami dan sirkulasi udara yang baik.',
                        'cover_image' => 'https://via.placeholder.com/800x600?text=' . urlencode($title),
                        'images' => json_encode(['https://via.placeholder.com/800x600?text=' . urlencode($title . ' 1')]),
                        'is_published' => true,
                        'is_headliner' => ($i === 1),
                        'sort_order' => $i,
                    ]
                );
            }
        }
    }
}
