<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksLocationLevel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){


            Schema::create('stocks_location_level', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('stock_id')->unsigned();
                $table->string('shop_location');
                $table->integer('current_level');
                $table->timestamps();
                $table->unique(array('stock_id','shop_location'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
