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
            $table->string('trade_name')->unique()->nullable();
            $table->string('full_name')->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('first_address')->nullable();
            $table->string('sec_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();
            $table->string('cr')->nullable();
            $table->string('tax_record')->nullable();
            $table->boolean('secondary_address')->nullable()->default('0');
            $table->string('secondary_address1')->nullable();
            $table->string('secondary_address2')->nullable();
            $table->string('sec_city')->nullable();
            $table->string('sec_state')->nullable();
            $table->string('sec_postal_code')->nullable();
            $table->string('sec_country')->nullable();
            $table->unsignedInteger('code_num')->unique();
            $table->string('invoicing_method')->nullable();
            $table->string('currency')->nullable();
            $table->string('email')->unique();
            $table->json('category')->nullable();
            $table->text('notes')->nullable();
            $table->string('language')->nullable();
            $table->boolean('send_data')->nullable()->default('0');
            $table->unsignedBigInteger('employee_id');
            $table->json('tag')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

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
