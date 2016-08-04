<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');//Big increment=UNSIGNED  Integer(larger set of +number)
            $table->integer('ticket_id')->unsigned()->unique();
            $table->enum('paid', array(0, 1));
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
