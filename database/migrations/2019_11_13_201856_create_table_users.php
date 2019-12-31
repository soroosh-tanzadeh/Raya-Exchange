<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("profile")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("nationalcode")->nullable();
            $table->string("bank_account")->nullable();
            $table->integer("verified_at")->nullable();
            $table->string("email")->nullable();
            $table->string("password")->nullable();
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
        Schema::dropIfExists('table_users');
    }
}
