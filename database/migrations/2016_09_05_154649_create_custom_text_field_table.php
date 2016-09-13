<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomTextFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_text_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('field_name');
            $table->string('form_name');
            $table->boolean('required')->default(False);
            $table->integer('max');

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
