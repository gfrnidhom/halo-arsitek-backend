<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = NewsCategory::all();

        if ($categories->isEmpty()) {
            return;
        }

        foreach ($categories as $category) {
            for ($i = 1; $i <= 2; $i++) {
                $title = "Artikel " . $category->name . " $i";
                News::firstOrCreate(
                    ['title' => $title],
                    [
                        'id' => Str::uuid(),
                        'slug' => Str::slug($title),
                        'category_id' => $category->id,
                        'content' => 'Ini adalah konten lengkap untuk artikel ' . $title . '. Di sini Anda dapat menambahkan paragraf panjang, penjelasan mendetail, dan informasi lainnya terkait topik yang dibahas. Artikel ini dirancang agar mudah dibaca dan memberikan informasi yang bermanfaat.',
                        'cover_image' => 'https://via.placeholder.com/800x400?text=' . urlencode($title),
                        'is_published' => true,
                    ]
                );
            }
        }
    }
}
