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
            $table->string('trade_name')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('mobile');
            $table->string('phone');
            $table->string('first_address');
            $table->string('sec_address');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            $table->string('commercial_register')->nullable();
            $table->string('tax_record')->nullable();
            $table->boolean('secondary_address')->nullable()->default('0');
            $table->string('secondary_address1')->nullable();
            $table->string('secondary_address2')->nullable();
            $table->string('sec_city')->nullable();
            $table->string('sec_state')->nullable();
            $table->string('sec_postal_code')->nullable();
            $table->string('sec_country')->nullable();
            $table->string('emp_name')->nullable();
            $table->string('currency');
            $table->unsignedBigInteger('opening_balance');
            $table->date('opening_balance_date');
            $table->string('email')->unique();
            $table->text('notes');
            $table->json('tag');
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
