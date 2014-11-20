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

	public static function addExpense($input,$uid) {

		$insert['brid']=$input['brid'];
		$insert['exid']=$input['exid'];
		$insert['date']=$input['date'];
		$insert['amount']=$input['amount'];
		$insert['note']=$input['note'];
		$insert['uid']=$uid;
		$insert['type']='expense';
		$insert['payment_type']=$input['payment_type'];
		$insert['created_at']=date('Y-m-d h:i:s');

		if($input['payment_type']=='cheque') {
			$insert['bid']=$input['bid'];
		}

		try {
			DB::table('transations')
				->insert($insert);
			GlobalHelper::setMessage("Expense Added successfully",'success');
			return true;
		}
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage());
			return false;
		}
	}

	public static function addReceipt($input,$uid) {
		$insert['source']=$input['source'];
		$insert['date']=$input['date'];
		$insert['amount']=$input['amount'];
		$insert['note']=$input['note'];
		$insert['uid']=$uid;
		$insert['type']='receipt';
		$insert['created_at']=date('Y-m-d h:i:s');

		try {
			DB::table('transations')->insert($insert);
			GlobalHelper::setMessage('Receipt added successfully','success');
		}
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage());
			return false;
		}
		
	}

	/*
		Options:
			start 0,
			limit 10,
			orderby tid,
			order desc,
			where array('collumn' =>'value')
	*/
	public function getExpense($uid,$option=array()) {
		/* query variables */
		$start=0;
		$limit=10;
		$orderby='transations.tid';
		$order='desc';

		/* Set query options */
		if(isset($option['start'])) {
			$start=$option['start'];
		}

		if(isset($option['limit'])) {
			$limit=$option['limit'];
		}

		if(isset($option['orderby'])) {
			$orderby=$option['orderby'];
		}

		if(isset($option['order'])) {
			$order=$option['order'];
		}

		/* buid query */
		$db=DB::table('transations')
			->select('transations.*','banks.title as bank','expense_type.title as expense_type','branches.title as branche')
			->leftJoin('banks','transations.bid','=','banks.bid')
			->leftJoin('expense_type','transations.exid','=','expense_type.exid')
			->leftJoin('branches','transations.brid','=','branches.brid')
			->where('type','expense')
			->orderby($orderby,$order)
			->skip($start)
			->take($limit);

		/* Where condtions */
		if(isset($option['where']) && count($option['where'] > 0)) {
			foreach($option['where'] as $col=>$val) {
				$db->where($col,$val);
			}
		}

		$data=$db->get();
		return $data;

	}

	public static function total_today_in() {
		$sum=DB::table('transations')
			->where('type','receipt')
			->whereNull('deleted_at')
			->where('date',date('Y-m-d'))
			->sum('amount');
		return $sum;
	}

	public static function total_today_out() {
		$sum=DB::table('transations')
			->whereNull('deleted_at')
			->where('type','expense')
			->where('date',date('Y-m-d'))
			->sum('amount');
		return $sum;
	}

	public static function total_month_out() {
		$first=date('Y-m-01',strtotime('this month'));
		$last=date('Y-m-t',strtotime('this month'));
		$sum=DB::table('transations')
			->whereNull('deleted_at')
			->where('type','expense')
			->whereBetween('date',array($first,$last))
			->sum('amount');
		return $sum;
	}

	public static function total_month_in() {
		$first=date('Y-m-01',strtotime('this month'));
		$last=date('Y-m-t',strtotime('this month'));
		$sum=DB::table('transations')
			->whereNull('deleted_at')
			->where('type','receipt')
			->whereBetween('date',array($first,$last))
			->sum('amount');
		return $sum;	
	}

}
