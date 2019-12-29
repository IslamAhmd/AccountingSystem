<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voname
     */
    public function up()
    {
        Schema::create('repos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->string('location');
            $table->boolean('active')->default('0');
            $table->boolean('primary')->default('0');
            $table->string('show');
            $table->string('show_emp_name')->nullable();
            $table->string('show_role_name')->nullable();
            $table->string('bill');
            $table->string('bill_emp_name')->nullable();
            $table->string('bill_role_name')->nullable();
            $table->string('store');
            $table->string('store_emp_name')->nullable();
            $table->string('store_role_name')->nullable();
            $table->timestamps();

            $table->foreign('show_emp_name')->references('name')->on('employees')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bill_emp_name')->references('name')->on('employees')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('store_emp_name')->references('name')->on('employees')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('show_role_name')->references('name')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('bill_role_name')->references('name')->on('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('store_role_name')->references('name')->on('roles')->onDelete('cascade')->onUpdate('cascade');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voname
     */
    public function down()
    {
        Schema::dropIfExists('repos');
    }
}
