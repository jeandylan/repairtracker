<?php

use Illuminate\Database\Seeder;

class suppliersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit=10;

        $faker = Faker\Factory::create(); //use faker to create Data
        for ($i = 0; $i < $limit; $i++) {
            DB::table('suppliers')->insert([
                'first_name' => $faker->firstName,
                'last_name' =>$faker->lastName,
                'company'=>$faker->company,
                'address' => $faker->streetAddress,
                'mobile_tel' =>$faker->phoneNumber,
                'email' => $faker->companyEmail
            ]);

        }
    }
}
