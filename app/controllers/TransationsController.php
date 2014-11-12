<?php

class TransationsController extends BaseController {

	protected $layout = 'layouts.master';

	public function index($type) {
		if($type=='expense') {
			$this->layout->title="<i class='fa fa-truck'> Add Expense</i>";
			$type="expense";
			$data=Transations::where('type','=','expense')->take(10)->orderby('date','desc')->get();
		}
		else {
			$this->layout->title="<i class='fa fa-money'> Add Cash Receipt</i>";
			$type="receipt";
			$data=Transations::where('type','=','receipt')->take(10)->orderby('date','desc')->get();
		}
		$this->layout->content = View::make('Transation')->with('data',$data)->with('type',$type);
	}

	public function addTransations() {
		$type=Input::get('type');
		$date=Input::get('date');
		$ref_no=Input::get('ref_no');
		$amount=Input::get('amount');
		$description=Input::get('description');
		$rules=array(
			'type'=>'required|in:expense,receipt',
			'date'=>'required|date_format:Y-m-d',
		);

		if($type=='expense') {
			$balance=Balance::get_balance(Auth::user()->uid);
			$rules['amount']='required|numeric|max:'.$balance;
		}
		elseif($type=='receipt') {
			$rules['amount']='required|numeric';			
		}
		else {
			return Redirect::back()
				->withInput()
				->with('error','Invalid form token, Plsease try again');
		}
		//GlobalHelper::dsm(Input::all());die;
		

		$messages =array(
			'type'=>'Invalid form token, Plsease try again',
			'date.date_format'=>'Invalid date format',
			'date.required'=>'Date field is required',
			'amount.digits'=>'Invalid amount',
			'amount.max'=>'Expense can not more than balance',
		);

		$validator = Validator::make(Input::all(), $rules, $messages);

		if ($validator->fails()) {
			return Redirect::back()
				->with('error','Plsease Fix the errors')
				->withInput()
				->withErrors($validator);
		}
		else {
			if(Transations::add_transations()) {
				return Redirect::back()
				->with('success',$type.' Add successfully');	
			}
			return Redirect::back();
		}
	}
}