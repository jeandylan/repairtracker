<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaasCompanyLocationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saas_company_location', function (Blueprint $table) {
            $table->increments('id');//Auto Incrmt
            $table->string('saas_company_id')->unique();
            $table->string('location_hostname');
            $table->boolean('isAdmin');  //does this location Controll All Others
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
