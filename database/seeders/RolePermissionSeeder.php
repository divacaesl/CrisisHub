<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'Admin',
            'Warga/Korban',
            'Relawan',
            'Donatur',
            'Organisasi Bantuan'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }
        
        // Create a default admin user
        $admin = User::firstOrCreate([
            'email' => 'admin@crisishub.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
        ]);
        
        $admin->assignRole('Admin');
    }
}
