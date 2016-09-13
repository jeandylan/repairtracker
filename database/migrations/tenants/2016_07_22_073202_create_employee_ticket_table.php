<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTicketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_ticket', function (Blueprint $table) {
            $table->integer('ticket_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->primary(array('ticket_id', 'employee_id'));
            $table->string('shop_location');;

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
        //
    }
}
