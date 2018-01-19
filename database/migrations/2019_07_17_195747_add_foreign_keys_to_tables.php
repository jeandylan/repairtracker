<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {

        });
        /*enums And contact info for customer */

        Schema::table('customer_address', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');

        });

        Schema::table('customer_email', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');

        });
        Schema::table('customer_telephone', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers');
            
        });
        /*supplier Contact info */
        Schema::table('supplier_address', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });

        Schema::table('supplier_email', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });

        Schema::table('supplier_telephone', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers');
        });





        /*ticket relationship*/
        Schema::table('tickets', function (Blueprint $table) {
           $table->foreign('customer_id')->references('id')->on('customers');
        });



        Schema::table('invoices', function (Blueprint $table) {
           $table->foreign('ticket_id')->references('id')->on('tickets');
        });

        Schema::table('stocks', function (Blueprint $table) {

        });

        Schema::table('suppliers', function (Blueprint $table) {

        });
        /*ticket Comments*/
        Schema::table('tickets_comments', function (Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('employees');
        });
        Schema::table('tickets_comments', function (Blueprint $table) {
            $table->foreign('ticket_id')->references('id')->on('tickets');
        });



        Schema::table('stock_supplier', function (Blueprint $table) {
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('stock_id')->references('id')->on('stocks');
        });

        Schema::table('stock_ticket', function (Blueprint $table) {
           $table->foreign('ticket_id')->references('id')->on('tickets');
           $table->foreign('stock_id')->references('id')->on('stocks');
        });
        Schema::table('employee_ticket', function (Blueprint $table) {
            $table->foreign('ticket_id')->references('id')->on('tickets');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //drop relationship first
        /*customer Contact*/
        Schema::table('customer_address', function (Blueprint $table) {
            $table->dropForeign('customer_address_customer_id_foreign');
        });
        Schema::table('customer_telephone', function (Blueprint $table) {
            $table->dropForeign('customer_telephone_customer_id_foreign');
        });
        Schema::table('customer_email', function (Blueprint $table) {
            $table->dropForeign('customer_email_customer_id_foreign');
        });
        /* supplier Contact details*/
        Schema::table('supplier_address', function (Blueprint $table) {
            $table->dropForeign('supplier_address_supplier_id_foreign');
        });
        Schema::table('supplier_telephone', function (Blueprint $table) {
            $table->dropForeign('supplier_telephone_supplier_id_foreign');
        });
        Schema::table('supplier_email', function (Blueprint $table) {
            $table->dropForeign('supplier_email_supplier_id_foreign');
        });
        /*Employee Contact Details*/
        Schema::table('employee_address', function (Blueprint $table) {
            $table->dropForeign('employee_address_employee_id_foreign');
        });
        Schema::table('employee_telephone', function (Blueprint $table) {
            $table->dropForeign('employee_telephone_employee_id_foreign');
        });
        Schema::table('employee_email', function (Blueprint $table) {
            $table->dropForeign('employee_email_employee_id_foreign');
        });


        Schema::table('employee_ticket', function (Blueprint $table) {
            $table->dropForeign('employee_ticket_employee_id_foreign');
            $table->dropForeign('employee_ticket_ticket_id_foreign');
        });

        Schema::table('stock_supplier', function (Blueprint $table) {
            $table->dropForeign('stock_supplier_stock_id_foreign');
            $table->dropForeign('stock_supplier_supplier_id_foreign');
        });

        Schema::table('stock_ticket', function (Blueprint $table) {
            $table->dropForeign('stock_ticket_stock_id_foreign');
            $table->dropForeign('stock_ticket_ticket_id_foreign');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign('tickets_customer_id_foreign');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign('invoices_ticket_id_foreign');
        });





        //drop tbls
        Schema::dropIfExists('customer_address');
        Schema::dropIfExists('customer_telephone');
        Schema::dropIfExists('customer_email');

        Schema::dropIfExists('supplier_address');
        Schema::dropIfExists('supplier_telephone');
        Schema::dropIfExists('supplier_email');

        Schema::dropIfExists('employee_address');
        Schema::dropIfExists('employee_telephone');
        Schema::dropIfExists('employee_email');
        
        Schema::dropIfExists('stock_supplier');
        Schema::dropIfExists('stock_ticket');
        Schema::dropIfExists('employee_ticket');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('stocks');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('employees');


    }
}
