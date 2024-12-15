<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleName = 'superadmin';
        $permissionName = 'see_superadmin_sections';

        $role = Role::firstOrCreate(['name' => $roleName]);
        $permission = Permission::firstOrCreate(['name' => $permissionName]);

        $admin1 = User::where('email', 'admin@way4solution.cz')->first();
        $admin2 = User::where('email', 'office@way4solution.cz')->first();

        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        $admin1->givePermissionTo($permissionName);
        $admin1->assignRole($roleName);

        $admin2->givePermissionTo($permissionName);
        $admin2->assignRole($roleName);
    }
}
