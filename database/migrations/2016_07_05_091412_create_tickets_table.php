<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');//Big increment=UNSIGNED  Integer(larger set of +number)
            $table->integer('customer_id')->unsigned();
            $table->string('model');
            $table->string('make');
            $table->longText('problem_definition')->nullable(); //give a detaile status of the problem
            $table->boolean('completed');
            $table->enum('status',array('waiting_confirmation','repairing','close'))->default('waiting_confirmation');
            $table->date('completed_date')->nullable();
            $table->dateTime('customer_appointment_date')->nullable();
            $table->date('estimated_completion_date')->nullable();
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
