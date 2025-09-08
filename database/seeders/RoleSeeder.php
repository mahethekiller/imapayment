<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'member']);
        Role::firstOrCreate(['name' => 'guest']);
            // Create roles
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $adminRole  = Role::firstOrCreate(['name' => 'admin']);

        // Create permissions
        $editorPermission = Permission::firstOrCreate(['name' => 'editor']);
        $adminPermission  = Permission::firstOrCreate(['name' => 'admin']);

        // Assign permissions to roles
        $editorRole->givePermissionTo($editorPermission);
        $adminRole->givePermissionTo($adminPermission);
    }
}
