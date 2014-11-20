<?php
class SettingCotroller extends BaseController {
	protected $layout = 'layouts.master';

	public function branchView($brid=false) {
		$data=UserBranches::getBranch(Auth::user()->uid);
		$this->layout->title="Branches Details";
		$editBranch=false;

		if($brid) {
			$editBranch=UserBranches::getBranch(Auth::user()->uid,$brid);
			if(count($editBranch) > 0) {
				$editBranch=$editBranch[0];
			}
			else {
				$editBranch=false;
			}
		}

		$this->layout->content=View::make('branches')
			->with('data',$data)
			->with('branch',$editBranch);
	}

	public function branchAdd($brid=false) {

		$rules=array(
			'title'=>'required',
			'person'=>'required',
			'contact_no'=>'required');

		$validator=Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::back()
				->with('error','Please Fix Errors')
				->withInput()
				->withErrors($validator);
		}

		$obj = new UserBranches;
		$obj->addBranch(Input::all(),$brid);
		return Redirect::to('setting/branch');
	}

	public function bankView($bid=false) {

		$data = UserBanks::getBank(Auth::user()->uid);
		$this->layout->title="Bank Details";
		$editBank=false;

		if($bid) {
			$editBank=UserBanks::getBank(Auth::user()->uid,$bid);
			if(count($editBank) > 0) {
				$editBank=$editBank[0];
			}
			else {
				$editBank=false;
			}
		}

		$this->layout->content=View::make('banks')
			->with('data',$data)
			->with('bank',$editBank);
	}

	public function bankAdd($bid=false) {

		$rules=array(
			'title'=>'required',
			'ac_number'=>'required'
		);

		$validator=Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::back()
				->with('error','Please Fix Errors')
				->withInput()
				->withErrors($validator);
		}

		$obj = new UserBanks;
		$obj->addBank(Input::all(),$bid);
		return Redirect::to('setting/bank');
	}

	public function expenseView($exid=false) {
		$data = ExpenseTypes::getExpenseType(Auth::user()->uid);
		$this->layout->title="Expense Types";
		$editExpense=false;

		if($exid) {
			$editExpense=ExpenseTypes::getExpenseType(Auth::user()->uid,$exid);
			if(count($editExpense) > 0) {
				$editExpense=$editExpense[0];
			}
			else {
				$editExpense=false;
			}
		}

		$this->layout->content=View::make('expenseType')
			->with('data',$data)
			->with('expense',$editExpense);
	}

	public function expenseAdd($exid=false) {

		$rules=array(
			'title'=>'required',
		);

		$validator=Validator::make(Input::all(),$rules);

		if($validator->fails()) {
			return Redirect::back()
				->with('error','Please Fix Errors')
				->withInput()
				->withErrors($validator);
		}

		$obj = new ExpenseTypes;
		$obj->addExpenseType(Input::all(),$exid);
		return Redirect::to('setting/expense');
	}

}

?>