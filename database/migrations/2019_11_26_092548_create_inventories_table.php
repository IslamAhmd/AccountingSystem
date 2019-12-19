<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('repo_id');
            $table->string('repo_name');
            $table->unsignedBigInteger('inventory_num')->unique();
            $table->date('date');
            $table->text('notes');
            $table->unsignedBigInteger('discount');
            $table->string('discount_type');
            $table->unsignedBigInteger('payment');
            $table->string('payment_type');
            $table->timestamps();

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
        Schema::dropIfExists('inventories');
    }
}
