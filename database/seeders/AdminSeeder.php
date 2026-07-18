<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@haloarsitek.com'],
            [
                'id' => Str::uuid(),
                'name' => 'Super Admin',
                'password_hash' => Hash::make('admin123'),
                'role' => 'SUPER_ADMIN',
                'is_active' => true,
            ]
        );
    }
}
