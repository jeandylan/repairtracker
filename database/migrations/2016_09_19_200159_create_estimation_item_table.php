<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstimationItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estimation_item', function (Blueprint $table) {
            $table->increments('id');//Big increment=UNSIGNED  Integer(larger set of +number)
            $table->integer('estimation_id')->unsigned();
            $table->integer('stock_id')->nullable()->unsigned();
            $table->string('product_name');
            $table->integer("selling_price");
            $table->integer('qty_out');
            $table->timestamps();

            $table->unique(array('estimation_id', 'stock_id'));

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
