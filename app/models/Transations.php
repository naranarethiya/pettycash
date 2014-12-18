<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Transations extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait,SoftDeletingTrait;

	/**
	 * @var string
	 */
	protected $table = 'transations';
	protected $primaryKey = "tid";
	protected $dates = ['deleted_at'];

	public function user() {
		return $this->belongsTo('users','uid','uid');
	}

	public function branche() {
		return $this->belongsTo('branches','brid','brid');
	}

	public function bank() {
		return $this->belongsTo('banks','bid','bid');
	}

	public function expense_type() {
		return $this->belongsTo('expense_type','exid');
	}



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
		$insert['source']=strtoupper($input['source']);
		$insert['date']=date('Y-m-d');
		$insert['amount']=$input['total'];
		$insert['note']=$input['note'];
		$insert['uid']=$uid;
		$insert['type']='expense';
		$insert['created_at']=date('Y-m-d h:i:s');
		
		try {
			DB::beginTransaction();
			$insertId=DB::table('transations')
				->insertGetId($insert);

			$count=count($input['amount']);

			for($i=0;$i<$count;$i++) {
				$item['tid']=$insertId;
				$item['exid']=$input['exid'][$i];	
				$item['payment_type']=$input['payment_type'][$i];
				$item['amount']=$input['amount'][$i];
				$item['note']=$input['trans_note'][$i];
				if($input['payment_type'][$i]=='cheque') {
					$item['bid']=$input['bid'][$i];
				}
				DB::table('transations_item')->insert($item);
			}
			DB::commit();
			return $insertId;
		}
		catch(Exception $e) {
			DB::rollback();
			GlobalHelper::setMessage($e->getMessage());
			return false;
		}
	}

	public static function addReceipt($input,$uid) {
		$insert['source']=$input['source'];
		$insert['date']=date('Y-m-d');
		//$insert['date']=$input['date'];
		$insert['amount']=$input['amount'];
		$insert['note']=$input['note'];
		$insert['uid']=$uid;
		$insert['type']='receipt';
		$insert['created_at']=date('Y-m-d h:i:s');

		try {
			$insert_id=DB::table('transations')->insertGetId($insert);
			$item['tid']=$insert_id;
			$item['amount']=$input['amount'];
			DB::table('transations_item')->insert($item);
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
			->select('transations.tid','transations.brid','transations.source','transations.uid','transations.ref_no','transations.type','transations.note as main_note','transations.balance','transations.amount as total_amount','transations.date','transations_item.*','banks.title as bank','expense_type.title as expense_type','branches.title as branche')
			->leftJoin('transations_item','transations.tid','=','transations_item.tid')
			->leftJoin('banks','transations_item.bid','=','banks.bid')
			->leftJoin('expense_type','transations_item.exid','=','expense_type.exid')
			->leftJoin('branches','transations.brid','=','branches.brid')
			->where('transations.type','expense')
			->where('transations.uid',$uid)
			->orderby($orderby,$order)
			->skip($start)
			->take($limit);

		/* Where condtions */
		if(isset($option['where']) && count($option['where'] > 0)) {
			foreach($option['where'] as $col=>$val) {
				$db->where($col,$val);
			}
		}

		try {
			$data=$db->get();
			return $data;
		}
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage);
			return false;
		}

	}

	public function searchTransation($uid,$option=array()) {
		/* query variables */
		$start=0;
		$limit=2;
		$orderby='transations.tid';
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
		$db=DB::table('transations')
			->select('transations.tid','transations.brid','transations.source','transations.uid','transations.ref_no','transations.type','transations.note as main_note','transations.balance','transations.amount as total_amount','transations.date','transations_item.t_item_id','transations_item.exid','transations_item.amount','transations_item.payment_type','transations_item.note','banks.title as bank','expense_type.title as expense_type','branches.title as branche')
			->leftJoin('transations_item','transations.tid','=','transations_item.tid')
			->leftJoin('banks','transations_item.bid','=','banks.bid')
			->leftJoin('expense_type','transations_item.exid','=','expense_type.exid')
			->leftJoin('branches','transations.brid','=','branches.brid')
			->where('transations.uid','=',$uid)
			->orderby($orderby,$order);

		if(isset($option['limit'])) {
			if($option['limit']!='0') {
				$db->take($option['limit']);
			}
		}

		if(isset($option['from']) && $option['from']!='') {
			$db->where('transations.date','>=',$option['from']);
		}

		if(isset($option['to']) && $option['to']!='') {
			$db->where('transations.date','<=',$option['to']);
		}

		if(isset($option['type']) && $option['type']!='') {
			$db->where('transations.type','=',$option['type']);
		}

		if(isset($option['payment_type']) && $option['payment_type']!='') {
			$db->where('transations_item.payment_type','=',$option['payment_type']);
		}

		if(isset($option['brid']) && $option['brid']!='' && $option['brid']!='0' ) {
			$db->where('transations.brid','=',$option['brid']);
		}

		if(isset($option['exid']) && $option['exid']!='' && $option['exid']!='0') {
			$db->where('transations_item.exid','=',$option['exid']);
		}

		if(isset($option['bid']) && $option['bid']!='' && $option['bid']!='0') {
			$db->where('transations_item.bid','=',$option['bid']);
		}

		if(isset($option['amount']) && $option['amount']!='' && $option['amount']!='0') {
			$db->where('transations_item.amount','=',$option['amount']);
		}

		if(isset($option['source']) && $option['source']!='') {
			$db->where('transations.source','LIKE','%'.$option['source'].'%');
		}

		/* Where condtions */
		if(isset($option['where']) && count($option['where'] > 0)) {
			foreach($option['where'] as $col=>$val) {
				$db->where($col,$val);
			}
		}
		try {
			return $data=$db->get();
		} 
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage);
			return false;
		}
	}

	public function closingBalance($uid,$date) {
		$balance=DB::table('transations')
			->select('balance')
			->where('date','<=',$date)
			->where('uid','=',$uid)
			->orderby('tid','desc')
			->limit(1)
			->get();
		if(count($balance) < 1) {
			return 0;
		}
		return $balance[0]->balance;
	}

	public function openingBalance($uid,$date) {
		$balance=DB::table('transations')
			->select('balance')
			->where('date','<',$date)
			->where('uid','=',$uid)
			->orderby('tid','desc')
			->limit(1)
			->get();
		if(count($balance) < 1) {
			return 0;
		}
		return $balance[0]->balance;
	}

	public static function total_today_in($uid) {
		
		$sum=DB::table('transations')
			->where('type','receipt')
			->whereNull('deleted_at')
			->where('date',date('Y-m-d'))
			->where('uid',$uid)
			->sum('amount');
		return $sum;
	}

	public static function total_today_out($uid) {
		$sum=DB::table('transations')
			->whereNull('deleted_at')
			->where('type','expense')
			->where('date',date('Y-m-d'))
			->where('uid',$uid)
			->sum('amount');
		return $sum;
	}

	public static function total_month_out($uid) {
		$first=date('Y-m-01',strtotime('this month'));
		$last=date('Y-m-t',strtotime('this month'));
		try {
			$sum=DB::table('transations')
				->whereNull('deleted_at')
				->where('type','expense')
				->where('uid',$uid)
				->whereBetween('date',array($first,$last))
				->sum('amount');
			return $sum;
		} 
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage);
			return false;
		}
	}

	public static function total_month_in($uid) {
		$first=date('Y-m-01',strtotime('this month'));
		$last=date('Y-m-t',strtotime('this month'));
		try {
			$sum=DB::table('transations')
				->whereNull('deleted_at')
				->where('type','receipt')
				->where('uid',$uid)
				->whereBetween('date',array($first,$last))
				->sum('amount');
			return $sum;
		} 
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage);
			return false;
		}
	}

	public function getSumTransation($uid,$type,$from,$to) {
		$sql="select `date`,sum(amount) as total from transations where `date` between ? and ?
		and `type`= ? and `uid`=? group by `date` order by date desc";
		try {
			$data=DB::select($sql,array($from,$to,$type,$uid)); 
			return $data; 
		} 
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage);
			return false;
		}
	}

	public function branchDelete($brid,$uid) {
		try {
			DB::table('branches')
			->where('brid',$brid)
			->where('uid',$uid)
			->update(array('deleted_at'=>date('Y-m-d h:i:s')));
			return true;

		} 
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage());
		}
		return false;
	}

	public function bankDelete($bid,$uid) {
		try {
			DB::table('banks')
			->where('bid',$bid)
			->where('uid',$uid)
			->update(array('deleted_at'=>date('Y-m-d h:i:s')));
			return true;
		} 
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage());
		}
		return false;
	}

	public function expenseTypeDelete($exid,$uid) {
		try {
			DB::table('expense_type')
			->where('exid',$exid)
			->where('uid',$uid)
			->update(array('deleted_at'=>date('Y-m-d h:i:s')));
			return true;

		} 
		catch(Exception $e) {
			GlobalHelper::setMessage($e->getMessage());
		}
		return false;
	}

}
