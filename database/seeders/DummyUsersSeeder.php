<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummyUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Warga Korban',
                'email' => 'warga@crisishub.com',
                'role' => 'Warga/Korban'
            ],
            [
                'name' => 'Relawan Lapangan',
                'email' => 'relawan@crisishub.com',
                'role' => 'Relawan'
            ],
            [
                'name' => 'Donatur Dermawan',
                'email' => 'donatur@crisishub.com',
                'role' => 'Donatur'
            ],
            [
                'name' => 'Organisasi Bantuan',
                'email' => 'organisasi@crisishub.com',
                'role' => 'Organisasi Bantuan'
            ]
        ];

        foreach ($users as $u) {
            $user = User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                ]
            );
            
            if (!$user->hasRole($u['role'])) {
                $user->assignRole($u['role']);
            }
        }
    }
}
