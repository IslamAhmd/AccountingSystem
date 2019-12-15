<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = Role::create([
        	'name' => 'super admin',
        	'admin' => 1
        ]);

        $permissions = Permission::get();

        $super_admin->permissions()->attach($permissions);

    }
}
