<?php

class ExpenseTypes extends Eloquent {

	use SoftDeletingTrait;

	/**
	 * @var string
	 */
	protected $table = 'expense_type';
	protected $primaryKey = "exid";

	public static function getExpenseType($uid,$exid=false) {

		$table=DB::table('expense_type')->where('uid',$uid);
		$table->where('deleted_at',NULL);
		if($exid) {
			$table->where('exid',$exid);
		}
		$data=$table->get();
		return $data;
	}

	 /*
	*	Return all bank of user by 'bid'=>'title'
	*/
	public static function expenseCombo($uid,$selectBox=true) {
		$data=self::getExpenseType($uid);
		$combo=array_column($data,'title','exid');
		if($selectBox) {
			array_unshift($combo, "--Select Expense Type--");	
		}
		return $combo;
	}

	public function addExpenseType($input,$exid=false) {
		$insert = array();
		$insert['title']=strtoupper($input['title']);
		$insert['note']=$input['note'];
		$insert['uid']=Auth::user()->uid;

		if($exid) {
			try {
				$insert['updated_at']=date('Y-m-d h:i:s');
				DB::table('expense_type')
				->where('uid',Auth::user()->uid)
				->where('exid',$exid)
				->update($insert);
				GlobalHelper::setMessage('Expense type update successfully','success');
				return true;
			}
			catch(Exception $e) {
				GlobalHelper::setMessage($e->getMessage());
				return false;
			}
			
		}
		else {
			try {
				$bank['created_at']=date('Y-m-d h:i:s');
				DB::table('expense_type')
				->insert($insert);
				GlobalHelper::setMessage('Expense type Added successfully','success');
				return true;
			}
			catch(Exception $e) {
				GlobalHelper::setMessage($e->getMessage());
				return false;
			}
		}
	}

}