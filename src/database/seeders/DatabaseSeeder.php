<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$this->call([
        	RoleSeeder::class,
    	]);
        \App\Models\User::factory(10)->create()->each(function($user){
            $roleStudent = Role::where('name','Student')->first();
            $roleAdmin = Role::where('name','Admin')->first();
            $roleId = [$roleStudent->id,$roleAdmin->id];
            $user->roles()->attach($roleId[rand(0,1)]);
        });
        \App\Models\Student::factory(20)->create()->each(function($student){
            $roleStudent = Role::where('name','Student')->first();
            $user = User::create([
                'name' => $student->name,
                'email' => $student->email,
                'password' => Hash::make('123456789')
            ]);
            $user->roles()->attach($roleStudent->id);
        });
    }
}
