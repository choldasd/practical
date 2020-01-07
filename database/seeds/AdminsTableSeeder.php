<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		DB::table('admins')->insert([
		   'name' => 'AppLocum Admin',
		   'email' => 'applocumadmin@yopmail.com',
		   'password' =>Hash::make('Password@123'),
		   'created_at' =>Date("Y-m-d H:i:s"),
		   'updated_at' =>Date("Y-m-d H:i:s")
	   ]);
    }
}
