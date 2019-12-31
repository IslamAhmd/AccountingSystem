<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesReposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voname
     */
    public function up()
    {
        Schema::create('employees_repos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('repo_id');
            $table->string('repo_name')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->unsignedBigInteger('show_employee_id')->nullable();
            $table->string('show_emp_name')->nullable();
            $table->unsignedBigInteger('bill_employee_id')->nullable();
            $table->string('bill_emp_name')->nullable();
            $table->unsignedBigInteger('store_employee_id')->nullable();
            $table->string('store_emp_name')->nullable();            
            $table->timestamps();


            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('show_employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('bill_employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('store_employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->foreign('repo_id')->references('id')->on('repos')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voname
     */
    public function down()
    {
        Schema::dropIfExists('employees_repos');
    }
}
