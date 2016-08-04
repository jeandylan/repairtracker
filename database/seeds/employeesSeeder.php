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
        for ($i = 0; $i < $limit; $i++) {
            DB::table('employees')->insert([
                'first_name' => $faker->firstName,
                'last_name' =>$faker->lastName,
                'date_of_birth' => $faker->date('Y-m-d'),
                'role'=>$faker->randomElement($array = array ('admin','cashier','technician'))
            ]);
            
            DB::table('employee_address')->insert([
                'employee_id' => $i,
                'address' => $faker->address,
                'type' => $faker->randomElement($array = array ('home','private','company'))

            ]);

            DB::table('employee_address')->insert([
                'employee_id' => $i,
                'address' => $faker->address,
                'type' => $faker->randomElement($array = array ('home','private','company'))

            ]);

            //generate  2 false telephone
            DB::table('employee_telephone')->insert([
                'employee_id' => $i,
                'telephone_number' => $faker->phoneNumber,
                'type' => $faker->randomElement($array = array ('home','private','company'))

            ]);

            DB::table('employee_telephone')->insert([
                'employee_id' => $i,
                'telephone_number' => $faker->phoneNumber,
                'type' => $faker->randomElement($array = array ('home','private','company'))

            ]);

            //generate False Email
            DB::table('employee_email')->insert([
                'employee_id' => $i,
                'email' => $faker->safeEmail,
                'type' => $faker->randomElement($array = array ('home','private','company'))

            ]);

        }
    }
}
