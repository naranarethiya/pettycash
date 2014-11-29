<?php

class UserBranches extends Eloquent {

	use SoftDeletingTrait;

	/**
	 * @var string
	 */
	protected $table = 'branches';
	protected $primaryKey = "brid";

	public static function getBranch($uid,$brid=false) {

		$table=DB::table('branches')->where('uid',$uid);
		$table->where('deleted_at',NULL);
		if($brid) {
			$table->where('brid',$brid);
		}
		$data=$table->get();
		return $data;
	}

	/*
	*	Return all bank of user by 'bid'=>'title'
	*/
	public static function branchCombo($uid,$selectBox=true) {
		$data=self::getBranch($uid);
		$combo=array_column($data,'title','brid');
		if($selectBox) {
			array_unshift($combo, "--Select Branch--");	
		}
		return $combo;
	}

	public function addBranch($input,$brid=false) {
		$branch = array();
		$branch['title']=strtoupper($input['title']);
		$branch['person']=strtoupper($input['person']);
		$branch['contact_no']=$input['contact_no'];
		$branch['note']=$input['note'];
		$branch['uid']=Auth::user()->uid;

		if($brid) {
			try {
				$branch['updated_at']=date('Y-m-d h:i:s');
				DB::table('branches')
				->where('uid',Auth::user()->uid)
				->where('brid',$brid)
				->update($branch);
				GlobalHelper::setMessage('Branch Detail update successfully','success');
				return true;
			}
			catch(Exception $e) {
				GlobalHelper::setMessage($e->getMessage());
				return false;
			}
			
		}
		else {
			try {
				$branch['created_at']=date('Y-m-d h:i:s');
				DB::table('branches')
				->insert($branch);
				GlobalHelper::setMessage('Branch Detail Added successfully','success');
				return true;
			}
			catch(Exception $e) {
				GlobalHelper::setMessage($e->getMessage());
				return false;
			}
		}
	}

}