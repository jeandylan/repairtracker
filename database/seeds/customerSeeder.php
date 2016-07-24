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
        for ($i = 0; $i < $limit; $i++) {
            DB::table('customers')->insert([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'date_of_birth' => $faker->date('Y-m-d'),
                'address' => $faker->address,
                'mobile_tel' => $faker->phoneNumber,
                'email' => $faker->safeEmail
                ///'tenant_id' => rand ($minTenantId,$maxTenantId)
            ]);
            
        }
    }
}
