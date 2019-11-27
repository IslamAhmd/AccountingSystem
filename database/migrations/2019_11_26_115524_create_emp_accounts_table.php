<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->text('notes');
            $table->string('role_name');
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
        Schema::dropIfExists('emp_accounts');
    }
}
