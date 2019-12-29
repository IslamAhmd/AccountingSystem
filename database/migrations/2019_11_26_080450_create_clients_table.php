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
            $table->string('telephone');
            $table->string('mobile');
            $table->string('first_address');
            $table->string('sec_address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            $table->string('cr')->nullable();
            $table->string('tax_record')->nullable();
            $table->boolean('secondary_address')->default('0');
            $table->string('secondary_address1')->nullable();
            $table->string('secondary_address2')->nullable();
            $table->string('sec_city')->nullable();
            $table->string('sec_state')->nullable();
            $table->string('sec_postal_code')->nullable();
            $table->string('sec_country')->nullable();
            $table->unsignedInteger('code_num')->unique();
            $table->string('invoicing_method');
            $table->string('currency');
            $table->string('email')->unique();
            $table->string('category');
            $table->text('notes');
            $table->string('language');
            // $table->unsignedBigInteger('price_id');
            // $table->string('price_name');
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
