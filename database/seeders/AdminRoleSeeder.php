<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Role;

class AdminRoleSeeder extends Seeder
{
    public function run(): void
    {
        $admin = Admin::find(1);

        if (!$admin) {
            $this->command->error('Admin ID 1 not found.');
            return;
        }

        $role = Role::where('slug', 'super_admin')->first();

        if (!$role) {
            $this->command->error(
                'Super Admin role not found. Run RoleSeeder first.'
            );
            return;
        }

        $admin->roles()->syncWithoutDetaching([
            $role->id,
        ]);

        $this->command->info(
            'Super Admin role assigned successfully.'
        );
    }
}