<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReposRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return voname
     */
    public function up()
    {
        Schema::create('repos_roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('repo_id');
            $table->unsignedBigInteger('show_role_id')->nullable();
            $table->string('show_role_name')->nullable();
            $table->unsignedBigInteger('bill_role_id')->nullable();
            $table->string('bill_role_name')->nullable();
            $table->unsignedBigInteger('store_role_id')->nullable();
            $table->string('store_role_name')->nullable();            
            $table->timestamps();

            $table->foreign('show_role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('bill_role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('store_role_id')->references('id')->on('roles')->onDelete('cascade');

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
        Schema::dropIfExists('repos_roles');
    }
}
