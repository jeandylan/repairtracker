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
        $testingShopLocationArray=array('mahebourg.nexus.saasrepair1.xyz','curepipe.nexus.saasrepair1.xyz','vacoas.nexus.saasrepair1.xyz');

        for ($i = 1; $i < $limit; $i++) {
            DB::table('suppliers')->insert([
                'first_name' => $faker->firstName,
                'last_name' =>$faker->lastName,
                'company'=>$faker->company,
            ]);
            //generate 2 fake address for supplier
            DB::table('supplier_address')->insert([
                'supplier_id' => $i,
                'address' => $faker->address,
                'type' => $faker->randomElement($array = array ('home','private','company')),

            ]);

            DB::table('supplier_address')->insert([
                'supplier_id' => $i,
                'address' => $faker->address,
                'type' => $faker->randomElement($array = array ('home','private','company')),


            ]);

            //generate  2 false telephone
            DB::table('supplier_telephone')->insert([
                'supplier_id' => $i,
                'telephone_number' => $faker->phoneNumber,


            ]);

            DB::table('supplier_telephone')->insert([
                'supplier_id' => $i,
                'telephone_number' => $faker->phoneNumber,
                'type' => $faker->randomElement($array = array ('home','private','company')),

            ]);

            //generate False Email
            DB::table('supplier_email')->insert([
                'supplier_id' => $i,
                'email' => $faker->safeEmail,
                'type' => $faker->randomElement($array = array ('home','private','company')),

            ]);

        }
    }
}
