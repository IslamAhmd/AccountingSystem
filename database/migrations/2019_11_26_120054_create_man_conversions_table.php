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
            $table->unsignedBigInteger('from_repo_id');
            $table->string('from_repo_name');
            $table->unsignedBigInteger('to_repo_id');
            $table->string('to_repo_name');
            $table->unsignedBigInteger('purchase_id');
            $table->text('notes');
            $table->timestamps();

            $table->foreign('from_repo_id')->references('id')->on('repos')->onDelete('cascade');
            $table->foreign('to_repo_id')->references('id')->on('repos')->onDelete('cascade');
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
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
