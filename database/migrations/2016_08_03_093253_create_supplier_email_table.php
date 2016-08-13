<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSupplierEmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_email', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('supplier_id')->unsigned();
            $table->string('email');
            $table->enum('type', array('home', 'company','private'));
            $table->timestamps();
        });
        Schema::create('txt_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('field_name');
            $table->string('form_name');
            $table->boolean('required');
            $table->integer('max');

        });
        Schema::create('txt_field_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('field_id');
            $table->string('field_data');
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
