<?php

class UserBanks extends Eloquent {

	use SoftDeletingTrait;

	/**
	 * @var string
	 */
	protected $table = 'banks';
	protected $primaryKey = "bid";

	public static function getBank($uid,$bid=false) {

		$table=DB::table('banks')->where('uid',$uid);
		$table->where('deleted_at',NULL);
		if($bid) {
			$table->where('bid',$bid);
		}
		$data=$table->get();
		return $data;
	}

	/*
	*	Return all bank of user by 'bid'=>'title'
	*/
	public static function bankCombo($uid,$selectBox=true) {
		$data=self::getBank($uid);
		$combo=array_column($data,'title','bid');
		if($selectBox) {
			$combo[0]="Select Bank";
			ksort($combo);
		}
		return $combo;
	}

	

	public function addBank($input,$bid=false) {
		$bank = array();
		$bank['title']=strtoupper($input['title']);
		$bank['ac_number']=$input['ac_number'];
		$bank['note']=$input['note'];
		$bank['balance']=0;
		$bank['uid']=Auth::user()->uid;

		if($bid) {
			try {
				$bank['updated_at']=date('Y-m-d h:i:s');
				DB::table('banks')
				->where('uid',Auth::user()->uid)
				->where('bid',$bid)
				->update($bank);
				GlobalHelper::setMessage('Bank Detail update successfully','success');
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
				DB::table('banks')
				->insert($bank);
				GlobalHelper::setMessage('Bank Detail Added successfully','success');
				return true;
			}
			catch(Exception $e) {
				GlobalHelper::setMessage($e->getMessage());
				return false;
			}
		}
	}

}