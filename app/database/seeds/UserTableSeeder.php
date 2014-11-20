<?php

class UserTableSeeder extends Seeder
{
	public function run()
	{
		DB::table('users')->delete();
		User::create(array(
			'name'     => 'Naran Arethiya',
			'email'    => 'naranarethiya@gmail.com',
			'password' => Hash::make('abc@123'),
			'temp' => 'abc@123',
		));
		
		DB::table('balance')->delete();
		$insert=array('uid'=>'1','balance'=>'0')
		DB::table('balance')->insert($insert);
	}
}

?>