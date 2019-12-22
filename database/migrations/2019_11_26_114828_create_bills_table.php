<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->string('client_name');
            $table->string('way');
            $table->unsignedBigInteger('bill_num')->unique();
            $table->unsignedBigInteger('employee_id');
            $table->string('employee_name');
            $table->date('billdate');
            $table->date('releasedate');
            $table->unsignedBigInteger('payment_conditions');
            $table->unsignedBigInteger('discount');
            $table->string('discount_type');
            $table->unsignedBigInteger('payment');
            $table->string('payment_type');
            $table->string('file');
            $table->boolean('paid')->default(0);
            $table->unsignedBigInteger('shipment_costs');
            $table->unsignedBigInteger('repo_id');
            $table->string('repo_name');
            $table->timestamps();


            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
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
        Schema::dropIfExists('bills');
    }
}
