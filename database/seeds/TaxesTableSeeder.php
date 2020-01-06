<?php

use Illuminate\Database\Seeder;
use App\Tax;

class TaxesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tax::create([

        	'name' => 'القيمه المضافه',
        	'value' => '14'

        ]);
    }
}
