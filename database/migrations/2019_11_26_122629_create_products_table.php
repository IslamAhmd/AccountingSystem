<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('desc');
            $table->unsignedBigInteger('selling_price');
            $table->unsignedBigInteger('first_tax');
            $table->unsignedBigInteger('sec_tax');
            $table->unsignedBigInteger('purchase_price');
            $table->string('product_code');
            $table->string('barcode');
            $table->string('brand');
            $table->text('notes');
            $table->boolean('disabled');
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
        Schema::dropIfExists('products');
    }
}
