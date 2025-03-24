<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ADMINISTRATIVE MODULE // 
            // PARAMETERS MODULE //
                // TYPE IDENTIFICATIONS //
                Permission::create(['name' => 'administrative.parameters.type_identifications.show']);
                Permission::create(['name' => 'administrative.parameters.type_identifications.create']);
                Permission::create(['name' => 'administrative.parameters.type_identifications.edit']);
                Permission::create(['name' => 'administrative.parameters.type_identifications.delete']);

                // ROLES //
                Permission::create(['name' => 'administrative.parameters.roles.show']);
                Permission::create(['name' => 'administrative.parameters.roles.create']);
                Permission::create(['name' => 'administrative.parameters.roles.edit']);
                Permission::create(['name' => 'administrative.parameters.roles.delete']);

            // USERS MODULE //
            Permission::create(['name' => 'administrative.users.show']);
            Permission::create(['name' => 'administrative.users.create']);
            Permission::create(['name' => 'administrative.users.edit']);
            Permission::create(['name' => 'administrative.users.delete']);


        // Sync all permissions to the admin role
        $permissions = Permission::all();
        $role = Role::findByName('admin');
        $role->syncPermissions($permissions);
    }
}