<?php

use Illuminate\Database\Seeder;
use App\Employee;
use App\Role;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$super_admin = Role::where('name', 'super admin')->first();
    	
        Employee::create([
            'name' => 'Admin',
            'mobile' => '123456',
            'phone' => '123456',
            'first_address' => 'atlas street',
            'sec_address' => 'faisal bank',
            'city' => 'alex',
            'governorate' => 'alexandria',
            'postal_code' => '12345',
            'country' => 'egypt',
            'language' => 'ara',
       		'email' => 'admin@system.com',
       		'notes' => 'Super Admin of Accounting System',
       		'role_name' => $super_admin
        ]);
    }
}
