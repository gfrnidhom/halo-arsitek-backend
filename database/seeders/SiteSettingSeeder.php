<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Halo Arsitek', 'type' => 'STRING'],
            ['key' => 'site_description', 'value' => 'Jasa Arsitek Terbaik dan Terpercaya', 'type' => 'STRING'],
            ['key' => 'contact_email', 'value' => 'info@haloarsitek.com', 'type' => 'STRING'],
            ['key' => 'contact_phone', 'value' => '+6281234567890', 'type' => 'STRING'],
            ['key' => 'address', 'value' => 'Jl. Arsitektur No. 1, Jakarta Pusat', 'type' => 'STRING'],
            ['key' => 'social_media', 'value' => json_encode(['instagram' => 'https://instagram.com/haloarsitek', 'facebook' => 'https://facebook.com/haloarsitek']), 'type' => 'JSON'],
        ];

        foreach ($settings as $setting) {
            SiteSetting::firstOrCreate(
                ['key' => $setting['key']],
                [
                    'id' => Str::uuid(),
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                ]
            );
        }
    }
}
