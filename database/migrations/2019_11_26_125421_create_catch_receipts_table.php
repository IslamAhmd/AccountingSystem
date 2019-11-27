<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatchReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catch_receipts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->double('amount');
            $table->string('type');
            $table->text('desc');
            $table->string('img');
            $table->unsignedBigInteger('code');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catch_receipts');
    }
}
