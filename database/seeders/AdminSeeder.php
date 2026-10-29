<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'bio' => 'super_admin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'bio' => 'admin',
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'bio' => 'manager',
            ],
            [
                'name' => 'Staff',
                'email' => 'staff@example.com',
                'bio' => 'staff',
            ],
        ];

        foreach ($admins as $data) {
            Admin::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'bio' => $data['bio'],
                    'password' => Hash::make('Admin@123'),
                ]
            );
        }
    }
}