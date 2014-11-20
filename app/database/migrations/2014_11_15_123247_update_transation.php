<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateTransation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transations',function() {
			$table->integer('brid')->after('uid');
			$table->intger('exid')->after('brid');
			$table->enum('payment_type',array('cheque','cash'))->after('exid');
			$table->int('bid')->after('payment_type');
			$table->string('source')->after('bid');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('transations');
	}

}
