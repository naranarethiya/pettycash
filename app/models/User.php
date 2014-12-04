<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	protected $primaryKey = "uid";

	public function transations() {
		return $this->hasMany('transations','uid','uid');
	}

	public function banks() {
		return $this->hasMany('banks','bid','bid');
	}

	public function branch() {
		return $this->hasMany('branches','brid','brid');
	}

	public function expense_type() {
		return $this->hasMany('expense_type','exid','exid');
	}
}
