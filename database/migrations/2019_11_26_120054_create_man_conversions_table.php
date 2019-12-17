<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManConversionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('man_conversions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from_repo');
            $table->unsignedBigInteger('to_repo');
            $table->unsignedBigInteger('purchase_num');
            $table->text('notes');
            $table->timestamps();

            $table->foreign('from_repo')->references('id')->on('repos')->onDelete('cascade');
            $table->foreign('to_repo')->references('id')->on('repos')->onDelete('cascade');
            $table->foreign('purchase_num')->references('purchase_num')->on('purchases')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('man_conversions');
    }
}
