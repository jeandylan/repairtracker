<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockingHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('stocking_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_id');
            $table->integer('employee_id')->unsigned()->nullable(); //store Employee And Admin Id(note nullable is for Customers)
            $table->string('reason');
            $table->integer('qty');
            $table->string('shop_location');
            $table->timestamps();

        });
    }
}
