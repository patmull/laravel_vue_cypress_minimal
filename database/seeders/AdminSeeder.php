<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'admin']);
        $permission = Permission::firstOrCreate(['name' => 'see_admin_sections']);

        // Admin for Way4 domain
        $user = User::where('email', 'test-user5@test.cz')->first();

        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        $user->givePermissionTo('see_admin_sections');
        $user->assignRole('admin');

        $tibogem = User::find(38);

        $tibogem->givePermissionTo('see_admin_sections');
        $tibogem->assignRole('admin');

        $testUser4 = User::find(17);

        $testUser4->givePermissionTo('see_admin_sections');
        $testUser4->assignRole('admin');

        $vikigemAdmin = User::where('email', 'viki.gem12@gmail.com')->first();

        $vikigemAdmin->givePermissionTo('see_admin_sections');
        $vikigemAdmin->assignRole('admin');

    }
}
