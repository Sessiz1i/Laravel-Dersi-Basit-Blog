<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		DB::table('admins')->insert([
			'name' => 'Ömer Ölgün',
			'email' => 'omer.olgn@gmail.com',
			'password' => bcrypt('aA1190358'),
		]);
	}
}



