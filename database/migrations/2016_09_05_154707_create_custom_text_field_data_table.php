<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomTextFieldDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_text_field_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('custom_text_field_id'); //foreign key from custom Text field
            $table->integer('entity_id'); //foreign key to reference Owner Of the field (e.g ticket Id of this Data)
            $table->string('field_data');
            $table->string('shop_location');
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
