+<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('gender');
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('status')->default(false);
            $table->integer('category_id')->nullable()->unsigned();
            $table->string('country')->nullable();
            $table->string('stage_name')->nullable()->unique();
            $table->string('username')->nullable()->unique();
            $table->string('type');
            $table->string('email')->nullable()->unique();
            $table->string('password', 60);
            $table->integer('role_id')->nullable()->unsigned();
            $table->boolean('is_artist')->default(false)->nullable();
            $table->timestamp('artist_on')->nullable();
            $table->boolean('is_request_active')->nullable()->default(false);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
