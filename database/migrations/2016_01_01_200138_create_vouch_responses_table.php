<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVouchResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouch_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vouch_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->boolean('answer');
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
        Schema::drop('vouch_responses');
    }
}
