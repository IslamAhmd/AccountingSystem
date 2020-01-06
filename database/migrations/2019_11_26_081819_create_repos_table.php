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
            $table->boolean('active')->default('1');
            $table->boolean('primary')->default('0');
            $table->string('show');
            $table->string('bill');
            $table->string('store');
            $table->timestamps();
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
