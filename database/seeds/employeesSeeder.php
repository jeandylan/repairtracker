<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class employeesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleTechnician = Role::create(['name' => 'technician']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleSuperAdmin = Role::create(['name' => 'superAdmin']);

        $permission = Permission::create(['name' => 'view dashboard']);
        $permission = Permission::create(['name' => 'view calendar']);
        $permission = Permission::create(['name' => 'view stock']);
        $permission = Permission::create(['name' => 'view ticket']);
        $permission = Permission::create(['name' => 'view all employees']);
        $permission = Permission::create(['name' => 'view location employees']);
        $permission = Permission::create(['name' => 'view supplier']);
        $permission = Permission::create(['name' => 'view import data']);
        $permission = Permission::create(['name' => 'view export data']);
        $permission = Permission::create(['name' => 'view setting']);

        $roleTechnician->givePermissionTo('view ticket');

        $roleAdmin->givePermissionTo(['view ticket','view location employees','view supplier','view stock','view calendar','view dashboard']);

        $roleSuperAdmin->givePermissionTo(['view dashboard','view calendar','view stock','view ticket','view all employees','view location employees','view supplier',
            'view import data','view export data','view setting']);



        $limit=10;
        $faker = Faker\Factory::create(); //use faker to create Data
        $testingShopLocation='mahebourg.nexus.saasrepair1.xyz';
        $testingShopLocationArray=array('mahebourg.nexus.saasrepair1.xyz','curepipe.nexus.saasrepair1.xyz','vacoas.nexus.saasrepair1.xyz');

        //generate Client dylan At mbg
        DB::table('employees')->insert([
            'first_name' => 'dylan',
            'last_name' =>'blais',
            'date_of_birth' => $faker->date('Y-m-d'),
            'email'=>'dylanblais1@gmail.com',
            'address'=>$faker->address,
            'telephone'=>$faker->phoneNumber,
            'password'=>Hash::make('pass'),
            'shop_location'=>$testingShopLocation,
        ]);

        DB::table('employees')->insert([
            'first_name' => 'stacy',
            'last_name' =>'nagalingum',
            'date_of_birth' => $faker->date('Y-m-d'),
            'email'=>'stacy1@gmail.com',
            'address'=>$faker->address,
            'telephone'=>$faker->phoneNumber,
            'password'=>Hash::make('pass'),
            'shop_location'=>$testingShopLocation,
        ]);




        for ($i = 1; $i < $limit; $i++) {
            $shopLocation=$faker->randomElement($array =$testingShopLocationArray );
            DB::table('employees')->insert([
                'first_name' => $faker->firstName,
                'last_name' =>$faker->lastName,
                'date_of_birth' => $faker->date('Y-m-d'),
                'email'=>$faker->safeEmail,
                'address'=>$faker->address,
                'telephone'=>$faker->phoneNumber,
                'password'=>Hash::make('pass'),
                'shop_location'=>$shopLocation,
            ]);
        }
    }
}
