<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Employee;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employee = Employee::where('name', 'Admin')
                            ->where('email', 'admin@system.com')
                            ->first();
        User::create([
            'name' => 'Admin',
            'employee_id' => $employee->id,
            'email' => 'admin@system.com',
            'password' => bcrypt('admin')
        ]);

    }
}
