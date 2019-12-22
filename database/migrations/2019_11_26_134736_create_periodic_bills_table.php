<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodicBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodic_bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subscription')->unique();
            $table->unsignedBigInteger('release_bill');
            $table->string('release_bill_type');
            $table->unsignedBigInteger('repeat_num');
            $table->date('first_bill_date');
            $table->boolean('active');
            $table->boolean('send_copy');
            $table->boolean('show_date');
            $table->boolean('auto_pay');
            $table->string('way');
            $table->unsignedBigInteger('client_id');
            $table->string('client_name');
            $table->unsignedBigInteger('payment_conditions');
            $table->unsignedBigInteger('discount');
            $table->string('discount_type');
            $table->unsignedBigInteger('payment');
            $table->string('payment_type');
            $table->string('file');
            $table->unsignedBigInteger('shipment_costs');
            $table->unsignedBigInteger('repo_id');
            $table->string('repo_name');

            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
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
        Schema::dropIfExists('periodic_bills');
    }
}
