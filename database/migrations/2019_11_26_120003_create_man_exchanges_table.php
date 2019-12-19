<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('man_exchanges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('repo_id');
            $table->string('repo_name');
            $table->unsignedBigInteger('purchase_num');
            $table->text('notes');
            $table->timestamps();

            $table->foreign('repo_id')->references('id')->on('repos')->onDelete('cascade');
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
        Schema::dropIfExists('man_exchanges');
    }
}
