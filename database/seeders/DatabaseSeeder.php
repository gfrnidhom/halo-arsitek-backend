<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            SiteSettingSeeder::class,
            ProjectCategorySeeder::class,
            ProjectSeeder::class,
            NewsCategorySeeder::class,
            NewsSeeder::class,
            ServiceSeeder::class,
            TestimonialSeeder::class,
            TeamMemberSeeder::class,
        ]);
    }
}
