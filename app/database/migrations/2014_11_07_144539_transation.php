<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Transation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('transations');
		Schema::create("transations",function($table) {
			$table->increments('tid');
			$table->integer('uid');
			$table->string('ref_no');
			$table->enum('type',array('expense','receipt'));
			$table->string('description');
			$table->float('amount');
			$table->float('balance');
			$table->date('date');
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::dropIfExists('balance');
		Schema::create("balance",function($table) {
			$table->integer('uid');
			$table->float('amount');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('balance');
		Schema::dropIfExists('transations');
	}

}
