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
            $table->string('supplier_name')->nullable();
            $table->date('date');
            // $table->string('data')->nullable();
            $table->unsignedBigInteger('payment_conditions');
            $table->unsignedBigInteger('discount')->nullable();
            $table->string('discount_type')->nullable();
            $table->unsignedBigInteger('payment')->nullable();
            $table->string('payment_type')->nullable();
            $table->unsignedBigInteger('repo_id')->nullable();
            $table->string('repo_name')->nullable();
            $table->unsignedBigInteger('shipment_costs')->nullable();
            $table->boolean('payment_check')->default('0');
            $table->string('pay_way')->nullable();
            $table->unsignedBigInteger('pay_id')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('paid')->default('0');
            $table->string('paid_way')->nullable();
            $table->unsignedBigInteger('paid_id')->nullable();
            $table->boolean('received')->default('0');
            $table->datetime('receiving_date')->nullable();
            $table->json('tag')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
