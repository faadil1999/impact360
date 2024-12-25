<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

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
    }
}
