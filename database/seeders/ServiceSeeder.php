<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['title' => 'Desain Arsitektur', 'icon' => 'home'],
            ['title' => 'Desain Interior', 'icon' => 'layout'],
            ['title' => 'Manajemen Konstruksi', 'icon' => 'tool'],
        ];

        foreach ($services as $index => $service) {
            Service::firstOrCreate(
                ['title' => $service['title']],
                [
                    'id' => Str::uuid(),
                    'description' => 'Kami menyediakan layanan ' . $service['title'] . ' terbaik yang disesuaikan dengan kebutuhan Anda, memastikan kualitas dan estetika.',
                    'icon' => $service['icon'],
                    'is_published' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
