<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->text('desc');
            $table->unsignedBigInteger('selling_price');
            $table->unsignedBigInteger('first_tax');
            $table->unsignedBigInteger('sec_tax');
            $table->unsignedBigInteger('purchase_price');
            $table->string('product_code')->unique();
            $table->string('barcode')->unique();
            $table->string('category');
            $table->string('brand');
            $table->text('notes');
            $table->boolean('repo');
            $table->unsignedBigInteger('repo_quantity');
            $table->unsignedBigInteger('least_quantity');
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
        Schema::dropIfExists('services');
    }
}
