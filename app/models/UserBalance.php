<?php

class UserBalance extends Eloquent {

	/**
	 * @var string
	 */
	protected $table = 'balance';
	protected $primaryKey = "uid";

	public static function get_balance($uid=1) {
		$balance=UserBalance::find($uid);
		return $balance->amount;
	}
}
