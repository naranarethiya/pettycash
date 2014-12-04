<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Options extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait,SoftDeletingTrait;

	/**
	 * @var string
	 */
	protected $table = 'branch';
	protected $primaryKey = "brid";

	public function user() {
		return $this->belongsTo('users','uid');
	}

	public function get_branch($uid,$bid=false) {

		$table=DB::table('branches')->where('uid',$uid);
		if($bid) {
			$table->where('brid',$bid);
		}
		$data=$table->get();
		return $data;
	}

	public function add_branch() {
		
	}

}