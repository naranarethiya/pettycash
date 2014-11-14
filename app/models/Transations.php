<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Transations extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait,SoftDeletingTrait;

	/**
	 * @var string
	 */
	protected $table = 'transations';
	protected $primaryKey = "tid";

	public static function add_transations() {
		$type=Input::get('type');
		$date=Input::get('date');
		$ref_no=Input::get('ref_no');
		$amount=Input::get('amount');
		$description=Input::get('description');

		$trans=new Transations();
		$trans->uid=Auth::user()->uid;
		$trans->ref_no=$ref_no;
		$trans->type=$type;
		$trans->description=$description;
		$trans->amount=$amount;
		$trans->date=$date;
		try {
			$trans->save();
			return true;
		}
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage());
			return false;
		}
	}

	public function manage_balance() {

	}

	public static function total_today_in() {
		$sum=DB::table('transations')
			->where('type','receipt')
			->where('date',date('Y-m-d'))
			->sum('amount');
		return $sum;
	}

	public static function total_today_out() {
		$sum=DB::table('transations')
			->where('type','expense')
			->where('date',date('Y-m-d'))
			->sum('amount');
		return $sum;
	}

	public static function total_month_out() {
		$first=date('Y-m-01',strtotime('this month'));
		$last=date('Y-m-t',strtotime('this month'));
		$sum=DB::table('transations')
			->where('type','expense')
			->whereBetween('date',array($first,$last))
			->sum('amount');
		return $sum;
	}

	public static function total_month_in() {
		$first=date('Y-m-01',strtotime('this month'));
		$last=date('Y-m-t',strtotime('this month'));
		$sum=DB::table('transations')
			->where('type','receipt')
			->whereBetween('date',array($first,$last))
			->sum('amount');
		return $sum;	
	}

}
