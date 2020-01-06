<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->string('client_name')->nullable();
            $table->string('name')->unique();
            $table->date('starts_at');
            $table->date('ends_at');
            $table->text('desc');
            $table->json('tag');
            $table->unsignedBigInteger('budget');
            $table->string('budget_type');
            $table->boolean('employee')->default('0');
            $table->unsignedBigInteger('shipment_num');
            $table->text('container_data');
            $table->date('shipment_date');
            $table->date('arrival_date');
            $table->json('abstract_name');
            $table->unsignedBigInteger('abstract_num');
            $table->json('shipment_location');
            $table->unsignedBigInteger('doc_credit_num');
            $table->unsignedBigInteger('gurantee_letter_num');
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
        Schema::dropIfExists('imports');
    }
}
