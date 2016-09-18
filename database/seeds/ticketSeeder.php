<?php

use Illuminate\Database\Seeder;

class ticketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit=10;
        //simulate CustomerId, will work only if customer was created first(look at customerSeeder)-10 customer simulated
        $minCustomerId=1;
        $maxCustomerId=7;
        $faker = Faker\Factory::create(); //use faker to create Data
        //create 2  Ticket For a random customer
        DB::table('tickets')->insert([
            'customer_id' =>rand ($minCustomerId,$maxCustomerId) ,
            'model' => $faker->word,
            'make' => $faker->word,
            'problem_definition' => $faker->sentences($nb = 3, $asText = true),
            'estimated_completion_date'=>$faker->dateTimeBetween($startDate = 'now', $endDate = '+2 months'),
            'shop_location'=>'mahebourg',
        ]);

        DB::table('tickets')->insert([
            'customer_id' =>rand ($minCustomerId,$maxCustomerId) ,
            'model' => $faker->word,
            'make' => $faker->word,
            'problem_definition' => $faker->sentences($nb = 3, $asText = true),
            'estimated_completion_date'=>$faker->dateTimeBetween($startDate = 'now', $endDate = '+2 months'),
            'shop_location'=>'mahebourg',
        ]);


//create Fake Comments for the 2 fake ticket
        for ($i = 0; $i < 8; $i++) {
            DB::table('tickets_comments')->insert([
                'employee_id' => rand(1,2),
                'ticket_id' => rand(1,2),
                'to_customer'=>rand(0,1),
                'comment' => $faker->sentences($nb = 3, $asText = true),
            ]);


        }

///Generate 10 random Ticket id >2
        for ($i = 0; $i < $limit; $i++) {
            $customerId=rand ($minCustomerId,$maxCustomerId);
            $shop_location=$faker->randomElement($array = array ('mahebourg','curepipe','vacoas'));
            DB::table('tickets')->insert([
                'customer_id' =>$customerId ,
                'model' => $faker->word,
                'make' => $faker->word,
                'problem_definition' => $faker->sentences($nb = 3, $asText = true),
                'estimated_completion_date'=>$faker->dateTimeBetween($startDate = 'now', $endDate = '+2 months'),
                'shop_location'=>$shop_location,
            ]);
        }

        for($z=0;$z< 5;$z++){
            $customerId=rand ($minCustomerId,$maxCustomerId);
            $ticketId=rand(1,5);
            DB::table('employee_ticket')->insert([
                'employee_id' => $customerId,
                'ticket_id' => $ticketId,
                'job_assign' => $faker->sentences($nb = 3, $asText = true),
                'hours_work_on'=>rand(1,2),
                'completed_percentage'=>rand(60,100),
                'estimated_completion_date'=>$faker->dateTimeBetween($startDate = 'now', $endDate = '+2 months')
            ]);
        }
    }
}
