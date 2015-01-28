<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class BankBook extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait,SoftDeletingTrait;

	/**
	 * @var string
	 */
	protected $table = 'bank_book';
	protected $primaryKey = "id";
	protected $dates = ['deleted_at'];

	public function bank() {
		return $this->belongsTo('banks','bid','bid');
	}

	public function search($uid,$option=array()) {
		/* query variables */
		$start=0;
		$limit=10;
		$orderby='bank_book.id';
		$order='desc';

		/* Set query options */
		if(isset($option['start'])) {
			$start=$option['start'];
		}

		if(isset($option['orderby'])) {
			$orderby=$option['orderby'];
		}

		if(isset($option['order'])) {
			$order=$option['order'];
		}

		/* buid query */
		$db=DB::table('bank_book')
			->select('bank_book.*','banks.title as bank')
			->leftJoin('banks','bank_book.bid','=','banks.bid')
			->where('bank_book.uid',$uid)
			->whereNull('bank_book.deleted_at')
			->orderby($orderby,$order);

		if(isset($option['limit'])) {
			if($option['limit']!='0') {
				$db->take($option['limit']);
			}
		}

		if(isset($option['from']) && $option['from']!='') {
			$db->where('bank_book.date','>=',$option['from']);
		}

		if(isset($option['to']) && $option['to']!='') {
			$db->where('bank_book.date','<=',$option['to']);
		}

		if(isset($option['source']) && $option['source']!='') {
			$db->where('bank_book.source','LIKE','%'.$option['source'].'%');
		}

		if(isset($option['type']) && $option['type']!='') {
			$db->where('bank_book.type','=',$option['type']);
		}

		if(isset($option['bid']) && $option['bid']!='' && $option['bid']!='0') {
			$db->where('bank_book.bid','=',$option['bid']);
		}

		if(isset($option['amount']) && $option['amount']!='') {
			$db->where('bank_book.amount','=',$option['amount']);
		}

		if(isset($option['ref_no']) && $option['ref_no']!='') {
			$db->where('bank_book.ref_no','LIKE','%'.$option['ref_no'].'%');
		}

		try {
			return $data=$db->get();
		} 
		catch(Exception $e) {
			dsm($e->getMessage());die;
			GlobalHelper::setMessage($e->getMessage());
			return false;
		}
	}

	public function addTransation($uid,$inputs,$balance) {
		$insert['type']=$inputs['type'];
		//$insert['source']=$inputs['source'];
		$insert['date']=$inputs['date'];
		$insert['bid']=$inputs['bid'];
		$insert['amount']=$inputs['amount'];
		$insert['ref_no']=$inputs['ref_no'];
		$insert['note']=$inputs['note'];
		$insert['created_at']=date('Y-m-d h:i:s');
		$insert['uid']=$uid;
		$insert['balance']=$balance;

	 	try {
	 		return DB::table('bank_book')->insert($insert);
 		}
	 	catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage());
			return false;
		}
	}
}

?>