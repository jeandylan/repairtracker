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

        //generate Client dylan At mbg
        DB::table('employees')->insert([
            'first_name' => 'dylan',
            'last_name' =>'blais',
            'date_of_birth' => $faker->date('Y-m-d'),
            'email'=>'dylanblais1@gmail.com',
            'password'=>Hash::make('pass'),
            'shop_location'=>'mahebourg',
            'role'=>'technician'
        ]);

        DB::table('employees')->insert([
            'first_name' => 'stacy',
            'last_name' =>'nagalingum',
            'date_of_birth' => $faker->date('Y-m-d'),
            'email'=>'stacy1@gmail.com',
            'password'=>Hash::make('pass'),
            'shop_location'=>'mahebourg',
            'role'=>'technician'
        ]);




        for ($i = 1; $i < $limit; $i++) {
            $shopLocation=$faker->randomElement($array = array ('mahebourg','curepipe','vacoas'));
            DB::table('employees')->insert([
                'first_name' => $faker->firstName,
                'last_name' =>$faker->lastName,
                'date_of_birth' => $faker->date('Y-m-d'),
                'email'=>$faker->safeEmail,
                'password'=>Hash::make('pass'),
                'shop_location'=>$shopLocation,
                'role'=>$faker->randomElement($array = array ('admin','cashier','technician'))
            ]);
            
            DB::table('employee_address')->insert([
                'employee_id' => $i,
                'address' => $faker->address,
                'type' => $faker->randomElement($array = array ('home','private','company')),
                'shop_location'=>$shopLocation,

            ]);

            DB::table('employee_address')->insert([
                'employee_id' => $i,
                'address' => $faker->address,
                'type' => $faker->randomElement($array = array ('home','private','company')),
                'shop_location'=>$shopLocation,

            ]);

            //generate  2 false telephone
            DB::table('employee_telephone')->insert([
                'employee_id' => $i,
                'telephone_number' => $faker->phoneNumber,
                'type' => $faker->randomElement($array = array ('home','private','company')),
                'shop_location'=>$shopLocation,

            ]);

            DB::table('employee_telephone')->insert([
                'employee_id' => $i,
                'telephone_number' => $faker->phoneNumber,
                'type' => $faker->randomElement($array = array ('home','private','company')),
                'shop_location'=>$shopLocation,

            ]);

            //generate False Email
            DB::table('employee_email')->insert([
                'employee_id' => $i,
                'email' => $faker->safeEmail,
                'type' => $faker->randomElement($array = array ('home','private','company')),
                'shop_location'=>$shopLocation,

            ]);

        }
    }
}
