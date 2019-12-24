<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('mobile');
            $table->string('phone');
            $table->string('first_address');
            $table->string('sec_address');
            $table->string('city');
            $table->string('governorate');
            $table->string('postal_code');
            $table->string('country');
			$table->string('language');
			$table->string('email')->unique();
            $table->text('notes');
            $table->string('role_name');
            $table->datetime('last_login_at')->nullable();
            $table->boolean('active')->nullable();
			$table->timestamps();
			
            $table->foreign('role_name')->references('name')->on('roles')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
