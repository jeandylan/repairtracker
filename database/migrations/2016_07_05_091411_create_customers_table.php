<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');//Big increments =UNSIGNED  Integer(larger set of +number)
            // $table->integer('tenant_id')->unsigned();;
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->string('home_tel')->nullable();
            $table->string('mobile_tel')->nullable();
            $table->string('mobile_tel_1')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('address_1')->nullable();
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
       // Schema::drop('customers');
    }
}
