<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinOffers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("user_id");
            $table->double("amount");
            $table->double("min_buy")->nullable();
            $table->string("type")->default("sell")->nullable();
            $table->integer("price_pre")->nullable();
            $table->string("coin");
            $table->boolean("is_active")->default(true)->nullable();
            $table->string("wallet")->nullable();
            $table->string("tx_hash")->nullable();
            $table->boolean("is_selled")->default(false)->nullable();
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
        Schema::dropIfExists('coin_offers');
    }
}
