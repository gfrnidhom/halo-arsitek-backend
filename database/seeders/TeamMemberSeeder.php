<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['name' => 'Andi Wijaya', 'role' => 'Principal Architect'],
            ['name' => 'Rina Melati', 'role' => 'Senior Interior Designer'],
            ['name' => 'Dodi Saputra', 'role' => 'Project Manager'],
        ];

        foreach ($members as $index => $member) {
            TeamMember::firstOrCreate(
                ['name' => $member['name']],
                [
                    'id' => Str::uuid(),
                    'role' => $member['role'],
                    'image' => 'https://via.placeholder.com/400x400?text=' . urlencode($member['name']),
                    'is_published' => true,
                    'sort_order' => $index + 1,
                ]
            );
        }
    }
}
