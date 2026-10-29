<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'users.view'   => 'View Users',
            'users.create' => 'Create Users',
            'users.update' => 'Update Users',
            'users.delete' => 'Delete Users',
            'dashboard.view' => 'View Dashboard',
            'users.view' => 'View Users', 
            'users.create' => 'Create Users',
            'users.update' => 'Update Users',
            'users.delete' => 'Delete Users',
            'products.view' => 'View Products',
            'products.create' => 'Create Products',
            'products.update' => 'Update Products',
            'products.delete' => 'Delete Products',
            'reports.view' => 'View Reports'
        ];

        foreach ($permissions as $slug => $name) {
            Permission::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }

        // Staff: view only
        $staff = Role::updateOrCreate(
            ['slug' => 'staff'],
            ['name' => 'Staff']
        );

        $staff->permissions()->sync(
            Permission::whereIn('slug', [
                'users.view',
            ])->pluck('id')
        );

        // Manager: view and create
        $manager = Role::updateOrCreate(
            ['slug' => 'manager'],
            ['name' => 'Manager']
        );

        $manager->permissions()->sync(
            Permission::whereIn('slug', [
                'users.view',
                'users.create',
            ])->pluck('id')
        );

        // Admin: view, update and delete
        $admin = Role::updateOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Admin']
        );

        $admin->permissions()->sync(
            Permission::whereIn('slug', [
                'users.view',
                'users.update',
                'users.delete',
            ])->pluck('id')
        );
    }
}