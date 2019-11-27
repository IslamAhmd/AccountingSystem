<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('import_id');
            $table->unsignedBigInteger('shipment_num');
            $table->text('container_data');
            $table->date('shipment_date');
            $table->date('arrival_date');
            $table->string('abstract_name');
            $table->unsignedBigInteger('abstract_num');
            $table->string('shipment_location');
            $table->unsignedBigInteger('doc_credit_num');
            $table->unsignedBigInteger('gurantee_letter_num');
            $table->timestamps();

            $table->foreign('import_id')->references('id')->on('clients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
}
