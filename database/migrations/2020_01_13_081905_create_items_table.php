<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prod_id');
            $table->string('prod_name')->nullable();
            $table->string('prod_desc')->nullable();
            $table->unsignedBigInteger('prod_selling_price')->nullable();
            $table->unsignedBigInteger('quantity')->nullable();
            $table->unsignedBigInteger('total')->nullable();
            $table->unsignedBigInteger('discount')->nullable();
            $table->unsignedBigInteger('shipment')->nullable();
            $table->unsignedBigInteger('paid')->nullable();
            $table->unsignedBigInteger('final_result')->nullable();
            $table->timestamps();

            $table->foreign('prod_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
