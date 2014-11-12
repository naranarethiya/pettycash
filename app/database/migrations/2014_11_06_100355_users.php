<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("users",function($table) {
			$table->increments('uid');
			$table->string('name',32);
			$table->string('email',50);
			$table->string('password',64);
			$table->string('temp',64);
			$table->string('remember_token', 100)->nullable();
			$table->timestamps('');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
