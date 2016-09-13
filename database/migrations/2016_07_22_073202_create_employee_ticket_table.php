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
            $table->increments('id');//Auto Incrmt
            $table->integer('ticket_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->string('job_assign');
            $table->integer('completed_percentage')->nullable();
            $table->integer('hours_work_on')->nullable();
            $table->date('expected_completed_on')->nullable();

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
