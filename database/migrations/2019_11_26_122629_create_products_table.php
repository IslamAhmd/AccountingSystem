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
            $table->string('name')->unique();
            $table->text('desc');
            $table->unsignedBigInteger('selling_price')->nullable();
            $table->unsignedBigInteger('purchase_price');
            $table->string('product_code')->unique();
            $table->string('barcode')->unique();
            $table->json('brand');
            $table->json('category');
            $table->text('notes');
            $table->boolean('repo')->default('0');
            $table->unsignedBigInteger('repo_quantity')->nullable();
            $table->unsignedBigInteger('repo_id')->nullable();
            $table->string('repo_name')->nullable();
            $table->unsignedBigInteger('least_quantity')->nullable();
            $table->boolean('disabled')->default('0');
            $table->unsignedBigInteger('supplier_id');
            $table->string('supplier_name')->nullable();
            $table->json('tag');
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');

            $table->foreign('repo_id')->references('id')->on('repos')->onDelete('cascade');


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
