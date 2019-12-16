<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('trade_name')->unique();
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
            $table->unsignedInteger('code_num')->unique();
            $table->string('billingmethod');
            $table->string('currency');
            $table->string('email')->unique();
            $table->string('category');
            $table->text('notes');
            $table->string('language');
            $table->string('prices');
            $table->boolean('send_data')->default('0');
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
        Schema::dropIfExists('clients');
    }
}
