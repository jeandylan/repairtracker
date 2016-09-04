<?php

use Illuminate\Database\Seeder;

class employeesSeeder extends Seeder
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

        for ($i = 1; $i < $limit; $i++) {
            DB::table('employees')->insert([
                'first_name' => $faker->firstName,
                'last_name' =>$faker->lastName,
                'date_of_birth' => $faker->date('Y-m-d'),
                'email'=>$faker->safeEmail,
                'password'=>Hash::make('pass'),
                'shop_location'=>$faker->randomElement($array = array ('mahebourg','curepipe','vacoas')),
                'role'=>$faker->randomElement($array = array ('admin','cashier','technician'))
            ]);
            
            DB::table('employee_address')->insert([
                'employee_id' => $i,
                'address' => $faker->address,
                'type' => $faker->randomElement($array = array ('home','private','company')),
                'shop_location'=>$faker->randomElement($array = array ('mahebourg','curepipe','vacoas')),

            ]);

            DB::table('employee_address')->insert([
                'employee_id' => $i,
                'address' => $faker->address,
                'type' => $faker->randomElement($array = array ('home','private','company')),
                'shop_location'=>$faker->randomElement($array = array ('mahebourg','curepipe','vacoas')),

            ]);

            //generate  2 false telephone
            DB::table('employee_telephone')->insert([
                'employee_id' => $i,
                'telephone_number' => $faker->phoneNumber,
                'type' => $faker->randomElement($array = array ('home','private','company')),
                'shop_location'=>$faker->randomElement($array = array ('mahebourg','curepipe','vacoas')),

            ]);

            DB::table('employee_telephone')->insert([
                'employee_id' => $i,
                'telephone_number' => $faker->phoneNumber,
                'type' => $faker->randomElement($array = array ('home','private','company')),
                'shop_location'=>$faker->randomElement($array = array ('mahebourg','curepipe','vacoas')),

            ]);

            //generate False Email
            DB::table('employee_email')->insert([
                'employee_id' => $i,
                'email' => $faker->safeEmail,
                'type' => $faker->randomElement($array = array ('home','private','company')),
                'shop_location'=>$faker->randomElement($array = array ('mahebourg','curepipe','vacoas')),

            ]);

        }
    }
}
