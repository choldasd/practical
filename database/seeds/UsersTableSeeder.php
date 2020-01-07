<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		DB::table('users')->insert([
		   'name' => 'Lenovo Laptop',
		   'email' => 'lenovo@gmail.com',
		   'website' => 'https://lenovo.com',
		   'password' =>Hash::make('Lenovo@123'),
		   'created_at' =>Date("Y-m-d H:i:s"),
		   'updated_at' =>Date("Y-m-d H:i:s")
	   ]);
    }
}
