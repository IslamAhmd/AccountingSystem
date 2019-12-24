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
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('repo_id');
            $table->string('emp_name');
            $table->string('repo_name');
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
