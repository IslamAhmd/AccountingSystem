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
            $table->unsignedBigInteger('unit_price')->nullable();
            $table->unsignedBigInteger('purchase_price');
            $table->string('service_code')->unique();
            $table->json('category');
            $table->text('notes');
            $table->boolean('disabled')->default('0');
            $table->string('supplier_name')->nullable();
            $table->unsignedBigInteger('supplier_id');
            $table->json('tag');
            $table->string('status')->nullable();
            $table->timestamps();

            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');

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
