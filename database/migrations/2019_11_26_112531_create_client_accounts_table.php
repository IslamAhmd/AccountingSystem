<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('code_num')->unique();
            $table->unsignedBigInteger('client_id');
            $table->string('currency');
            $table->string('email')->unique();
            $table->text('notes');
            $table->string('language');
            $table->boolean('send_data');
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
        Schema::dropIfExists('client_accounts');
    }
}
