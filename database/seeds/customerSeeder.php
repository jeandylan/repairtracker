<?php

use Illuminate\Database\Seeder;

class customerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit=10; //number Of Customer To generate
        $faker = Faker\Factory::create(); //use faker to create Data

        for ($i = 1; $i < $limit; $i++) {
            DB::table('customers')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'date_of_birth' => $faker->date('Y-m-d'),

            ]);
//generate 2 fake address for customer
            DB::table('customer_address')->insert([
                'customer_id' => $i,
                'address' => $faker->address,
                'type' => $faker->randomElement($array = array ('home','private','company'))

            ]);

            DB::table('customer_address')->insert([
                'customer_id' => $i,
                'address' => $faker->address,
                'type' => $faker->randomElement($array = array ('home','private','company'))

            ]);

            //generate  2 false telephone
            DB::table('customer_telephone')->insert([
                'customer_id' => $i,
                'telephone_number' => $faker->phoneNumber


            ]);

            DB::table('customer_telephone')->insert([
                'customer_id' => $i,
                'telephone_number' => $faker->phoneNumber,
                'type' => $faker->randomElement($array = array ('home','private','company'))


            ]);

            //generate False Email
            DB::table('customer_email')->insert([
                'customer_id' => $i,
                'email' => $faker->safeEmail,
                'type' => $faker->randomElement($array = array ('home','private','company'))

            ]);
        }
    }
}
