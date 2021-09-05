<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            "admin", "manager", "editor", "user", "viewer"
         ];
        for($i=0; $i<count($roles); $i++){
            Role::create([
                'name' => $roles[$i],
                'guard_name' => 'api'
            ]);
        }
        Permission::create(['name' => 'edit students']);
        Permission::create(['name' => 'delete students']);
    }
}
