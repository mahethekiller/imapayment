<?php
namespace Database\Seeders;

use App\Models\LandingPage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Roles
        $adminRole  = Role::firstOrCreate(['name' => 'admin']);
        $memberRole = Role::firstOrCreate(['name' => 'member']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);

        // Create Permissions
        $adminPermission  = Permission::firstOrCreate(['name' => 'admin']);
        $editorPermission = Permission::firstOrCreate(['name' => 'editor']);
        $memberPermission = Permission::firstOrCreate(['name' => 'member']);

        // Assign permissions to roles
        $adminRole->givePermissionTo($adminPermission);
        $editorRole->givePermissionTo($editorPermission);
        $memberRole->givePermissionTo($memberPermission);

        // Create Users and Assign Roles
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name'     => 'Admin',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);

        $member = User::firstOrCreate([
            'email' => 'member@example.com',
        ], [
            'name'     => 'Member',
            'password' => Hash::make('password'),
        ]);
        $member->assignRole($memberRole);
        $member2 = User::firstOrCreate([
            'email' => 'imareport@ima-india.com',
        ], [
            'name'     => 'Member',
            'password' => Hash::make('Report@2025'),
        ]);
        $member2->assignRole($memberRole);

        $editor = User::firstOrCreate([
            'email' => 'editor@example.com',
        ], [
            'name'     => 'Editor',
            'password' => Hash::make('password'),
        ]);
        $editor->assignRole($editorRole);

        // Create a sample Landing Page
        LandingPage::firstOrCreate([
            'slug' => 'demo',
        ], [
            'title'            => 'Demo Landing',
            'member_price'     => 1000,
            'non_member_price' => 1200,
            'gst_percent'      => 18.0,
            'workshop_mode'    => false,
            'enable_pdf_download'      => true,
        ]);
    }
}
