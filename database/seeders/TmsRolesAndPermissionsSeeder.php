<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class TmsRolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * We want to create 5 roles.
     * 
     * We want to create 4 permissions.
     * 
     * We want to assign all the permissions to all roles (everybody can do everything). For now.
     * 
     * 
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'delete']);
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'update']);

        // create roles and assign created permissions to these roles
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $dispatcherRole = Role::create(['name' => 'dispatcher']);
        $dispatcherRole->givePermissionTo(['edit', 'delete', 'create', 'update']);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['edit', 'delete', 'create', 'update']);

        $serviceRole = Role::create(['name' => 'service']);
        $serviceRole->givePermissionTo(['edit', 'delete', 'create', 'update']);

        $salesRole = Role::create(['name' => 'sales']);
        $salesRole->givePermissionTo(['edit', 'delete', 'create', 'update']);

    }
}
