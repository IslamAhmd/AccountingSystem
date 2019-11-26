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
            $table->unsignedInteger('duration');
            $table->string('duration_type');
            $table->unsignedInteger('repeated_num');
            $table->date('first_bill');
            $table->boolean('active');
            $table->boolean('send_data');
            $table->boolean('show_date');
            $table->boolean('auto_pay');
            $table->unsignedBigInteger('client_id');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

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
