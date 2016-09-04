<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_ticket', function (Blueprint $table) {
            $table->increments('id');//Big increment=UNSIGNED  Integer(larger set of +number)
            $table->integer('ticket_id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->integer('qty_out')->unsigned();
            $table->string('shop_location');
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
       
    }
}
