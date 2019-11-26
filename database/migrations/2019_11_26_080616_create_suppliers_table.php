<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('trade_name');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile');
            $table->string('phone');
            $table->string('first_address');
            $table->string('sec_address');
            $table->string('city');
            $table->string('governorate');
            $table->string('postal_code');
            $table->string('country');
            $table->string('commercial_register')->default('null');
            $table->string('tax_record')->default('null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
