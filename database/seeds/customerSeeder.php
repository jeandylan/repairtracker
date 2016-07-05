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
        $limit=5;
        $minTelNum=3333333;
        $maxTelNum=9999999;
        $minTenantId=1;
        $maxTenantId=4;
        for ($i = 0; $i < $limit; $i++) {
            DB::table('customers')->insert([
                'first_name' => str_random(10),
                'last_name' => str_random(20),
                'date_of_birth' => date('Y-m-d'),
                'address' => str_random(40),
                'mobile_tel' => rand ($minTelNum,$maxTelNum),
                'email' => str_random(10) . '@gmail.com',
                ///'tenant_id' => rand ($minTenantId,$maxTenantId)
            ]);
        }
    }
}
