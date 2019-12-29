<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            // $table->unsignedBigInteger('client_id');
            // $table->string('client_name');
            $table->string('name')->unique();
            $table->string('method');
            $table->date('price_date');
            $table->unsignedBigInteger('discount');
            $table->string('discount_type');
            $table->unsignedBigInteger('shipment_costs');
            $table->timestamps();

            // $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
