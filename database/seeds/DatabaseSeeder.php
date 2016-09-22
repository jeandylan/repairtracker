<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(customerSeeder::class);
        $this->call(employeesSeeder::class);
        $this->call(ticketSeeder::class);
        $this->call(suppliersSeeder::class);
        $this->call(stocksSeeder::class);
        $this->call(stockSupplierSeeder::class);
        $this->call(stockTicketSeeder::class);
        $this->call(invoicesSeeder::class);
        $this->call(EstimationSeeder::class);

    }
}
