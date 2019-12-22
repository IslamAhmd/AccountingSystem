<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('supplier_name');
            $table->unsignedBigInteger('purchase_num')->unique();
            $table->date('date');
            $table->unsignedBigInteger('payment_conditions');
            $table->unsignedBigInteger('discount');
            $table->string('discount_type');
            $table->unsignedBigInteger('payment');
            $table->string('payment_type');
            $table->boolean('paymeny_check')->default(0);
            $table->string('pay_way')->nullable();
            $table->unsignedBigInteger('pay_id')->nullable();
            $table->boolean('received')->default(0);
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
        Schema::dropIfExists('purchases');
    }
}
