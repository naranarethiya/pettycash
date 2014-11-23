<?php

class SearchController extends BaseController {
	protected $layout = 'layouts.master';

	public function index() {
		$this->layout->title="Search Transations";
		$data=array();
		$data['branchCombo']=UserBranches::branchCombo(Auth::user()->uid);
		$data['bankCombo']=UserBanks::bankCombo(Auth::user()->uid);
		$data['expTypeCombo']=ExpenseTypes::expenseCombo(Auth::user()->uid);
		$this->layout->content=View::make('searchPage')
			->with('data',$data)
			->with('title','Search');
	}

	public function search() {
		$rules=array(
			'source'=>'min:3',
			'from'=>'date_format:Y-m-d',
			'to'=>'date_format:Y-m-d',
			'amount'=>'numeric',
			'payment_type'=>'in:cash,cheque',
			'limit'=>'in:30,60,100,200'
		);

		$messages =array(
			'date.date_format'=>'Invalid date format',
			'amount.numeric'=>'Invalid amount',
			'source.min' =>'Source/Pay to is longer than 3 chars'
		);

		$validator = Validator::make(Input::all(),$rules,$messages);

		if($validator->fails()) {
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}
		$trans = new Transations;
		$data['transations']=$trans->searchTransation(Auth::user()->uid,Input::all());


		$this->layout->title="Search Result";
		
		$data['branchCombo']=UserBranches::branchCombo(Auth::user()->uid);
		$data['bankCombo']=UserBanks::bankCombo(Auth::user()->uid);
		$data['expTypeCombo']=ExpenseTypes::expenseCombo(Auth::user()->uid);
		$this->layout->content=View::make('searchPage')
			->with('data',$data)
			->with('title','Search');

		$this->layout->content = View::make('searchResult')
			->with('data',$data)
			->withInput(Input::all());
	}
}

?>