<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Balance extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * @var string
	 */
	protected $table = 'balance';
	protected $primaryKey = "uid";

	public static function get_balance($uid=1) {
		$balance=Balance::find($uid);
		return $balance->amount;
	}
}
