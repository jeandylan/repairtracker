<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaasCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saas_company', function (Blueprint $table) {
            $table->increments('id');//Auto Incrmt
            $table->string('company_name')->unique();
            $table->string('owner_first_name');
            $table->string('owner_last_name');
            $table->integer('max_customer');
            $table->integer('max_employee');
            $table->boolean('isActive');
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
