<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //generate roles from json
        $roles = File::get(database_path('data/users/Roles.json'));
        $permissions = File::get(database_path('data/users/Permissions.json'));

        if ($roles) {
            $role_data = json_decode($roles);
            foreach ($role_data as $obj) {
                Role::firstOrCreate([
                    'name' => $obj->name,
                    'space' => $obj->space,
                    'guard_name' => config('auth.defaults.guard')
                ]);
            }

            $admin = Role::getSuperAdmin();
            $member = Role::getOrganizationMember();
            $founder = Role::getOrganizationFounder();
            $beneficiary = Role::getBeneficiary();

            $permission_data = json_decode($permissions);
            foreach ($permission_data as $obj) {
                $permission = Permission::firstOrCreate([
                    'name' => $obj->name
                ]);

                if (str_starts_with($permission->name, 'admin')) {
                    $admin->givePermissionTo($permission->name);
                }

                if (str_starts_with($permission->name, 'founder')) {
                    $founder->givePermissionTo($permission->name);
                }

                if (str_starts_with($permission->name, 'member')) {
                    $member->givePermissionTo($permission->name);
                }

                if (str_starts_with($permission->name, 'beneficiary')) {
                    $beneficiary->givePermissionTo($permission->name);
                }
            }
        }
    }
}
