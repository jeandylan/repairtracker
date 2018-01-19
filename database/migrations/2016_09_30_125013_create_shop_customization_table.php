<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopCustomizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_customization', function (Blueprint $table) {
            $table->integer('id')->unique()->default(1);//Big increment=UNSIGNED  Integer(larger set of +number)
            $table->longText('invoice_email_header')->nullable();
            $table->longText('invoice_email_footer')->nullable();
            $table->longText('estimation_email_footer')->nullable();
            $table->longText('estimation_email_header')->nullable();
            $table->text('color')->nullable();
            $table->string('gmail_address')->nullable();
            $table->string('gmail_password')->nullable();
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
