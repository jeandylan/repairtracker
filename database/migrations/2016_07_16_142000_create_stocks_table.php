<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');//Big increment=UNSIGNED  Integer(larger set of +number)
            $table->string('product_name')->unique(); //e.g Iphone4 screen
            $table->float('selling_price');
            $table->integer('reorder_level')->unsigned(); //minimum reordering level
            $table->string('barcode');
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
