<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat Roles (menggunakan guard 'web' dan 'api')
        $roles = [
            'Admin',
            'Warga/Korban',
            'Relawan',
            'Donatur',
            'Organisasi Bantuan'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'api']);
        }

        // Buat Akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@crisishub.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Berikan role Admin ke user tersebut
        if (!$admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }
    }
}
