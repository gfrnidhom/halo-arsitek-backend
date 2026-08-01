<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['name' => 'Budi Santoso', 'role' => 'Klien Residensial', 'project' => 'Rumah Tropis Budi'],
            ['name' => 'Siti Aminah', 'role' => 'Klien Komersial', 'project' => 'Kantor Minimalis Startup X'],
            ['name' => 'Rahmat Hidayat', 'role' => 'Klien Interior', 'project' => 'Interior Cafe Rahmat'],
        ];

        foreach ($testimonials as $index => $testimonial) {
            Testimonial::firstOrCreate(
                ['name' => $testimonial['name']],
                [
                    'id' => Str::uuid(),
                    'quote' => 'Pelayanan dari tim Halo Arsitek sangat memuaskan, desainnya sesuai dengan impian kami! Proses pengerjaannya juga rapi dan tepat waktu.',
                    'role' => $testimonial['role'],
                    'project' => $testimonial['project'],
                    'avatar_url' => 'https://via.placeholder.com/150?text=' . urlencode($testimonial['name']),
                    'is_published' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
