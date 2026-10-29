<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Admin@123456'),
                'is_admin' => true,
            ]
        );

        // Assign super-admin role
        $role = Role::where('slug', 'super-admin')->first();

        if ($role) {
            $admin->roles()->syncWithoutDetaching([$role->id]);
        }

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: Admin@123456');
    }
}