<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Roles'
        ];
        $rolesPermission = Permission::create(['name' => 'Roles']);
        $adminRole = Role::where('name', 'Admin')->first();
        $permissionRole = PermissionRole::create(['permission_id' => $rolesPermission->id, 'role_id' => $adminRole->id]);
    }
}
