<?php

class TransationsController extends BaseController {

	protected $layout = 'layouts.master';

	public function receipt() {
		$this->layout->title="<i class='fa fa-money'> Credit</i>";
		$data=Transations::where('type','receipt')
			->take(10)
			->join('transations_item','transations.tid','=','transations_item.tid')
			->where('uid',Auth::user()->uid)
			->orderby('transations.tid','desc')
			->get();

		$this->layout->content = View::make('receipt')
			->with('data',$data);
	}

	public function expense() {
		$this->layout->title="<i class='fa fa-truck'> Debit</i>";
		$trans= new Transations;
		$data['transations']=$trans->getExpense(Auth::user()->uid);
		
		$data['branchCombo']=UserBranches::branchCombo(Auth::user()->uid);
		$data['bankCombo']=UserBanks::bankCombo(Auth::user()->uid);
		$data['expTypeCombo']=ExpenseTypes::expenseCombo(Auth::user()->uid);
		//dsm($data);
		$this->layout->content = View::make('expense')
			->with('data',$data);
	}

	public function addReceipt() {
		$date=Input::get('date');
		$source=Input::get('source');
		$amount=Input::get('amount');
		$description=Input::get('description');
		$rules=array(
			'source'=>'required',
			'amount'=>'required|numeric|min:1',
			/*'date'=>'required|date_format:Y-m-d',*/
		);

		$messages =array(
			'date.date_format'=>'Invalid date format',
			'date.required'=>'Date field is required',
			'amount.numeric'=>'Invalid amount',
			'amount.min'=>'Invalid amount',
			'source.required' =>'Source is required'
		);

		$validator = Validator::make(Input::all(),$rules,$messages);

		if($validator->fails()) {
			return Redirect::back()
				->with('error','Plsease Fix the errors')
				->withInput()
				->withErrors($validator);
		}

		Transations::addReceipt(Input::all(),Auth::user()->uid);

		return Redirect::to('receipt');
	}

	public function addExpense() {
		/* get branch,expense type id by comma seperated for validation */
		$branchIds=keysImplode(UserBranches::branchCombo(Auth::user()->uid,false));
		$expenseIds=keysImplode(ExpenseTypes::expenseCombo(Auth::user()->uid,false));
		$bankIds=keysImplode(UserBanks::bankCombo(Auth::user()->uid,false));

		/* available balance */
		$balance=UserBalance::get_balance(Auth::user()->uid);

		/* validation rules */
		$rules=array(
			'source'=>'required',
			'brid'=>'required|in:'.$branchIds,
		);

		$messages=array(
			'source.required'=>'Pay to is required',
			'brid.in'=>'Invalid branch selected',
			'exid.in'=>'Invalid Expense type selected',
			'date.date_format'=>'Invalid date format, format must YYYY-MM-DD',
			'amount.max' => 'Expense Amount not greater than available balace',
			'amount.min' => 'Expense Amount not less than one',
			'payment_type.in'=>'Invalid payment type',
			'bid.in'=>'Invalid Bank selected',
			'total.max'=>'Total Amount can not greater than available balace'
		);

		$count=count(Input::get('exid'));

		for($i=0;$i<$count;$i++) {
			$rules['exid.'.$i]='required|in:'.$expenseIds;
			$rules['amount.'.$i]='required|numeric|max:'.$balance.'|min:1';
			$rules['payment_type.'.$i]='required|in:cash,cheque';
			$payment_type=Input::get('payment_type');
			if($payment_type[$i]=='cheque') {
				$rules['bid.'.$i]='required|in:'.$bankIds;
				$messages['bid.'.$i.'.in']='Invalid bank selected';
			}
			$messages['exid.'.$i.'.in']='Invalid Expense type selected';
			$messages['amount.'.$i.'.max']='Expense Amount not greater than available balance';
			$messages['payment_type.'.$i.'.in']='Invalid payment type';
		}

		$total=array_sum(Input::get('amount'));
		$rules['total']='max:'.$balance;
		$input=Input::all();
		$input['total']=$total;

		$validator=Validator::make($input,$rules,$messages);
		$messages = $validator->messages();
		if($validator->fails()) {
			return Redirect::back()
				->withErrors($validator);
		}
		else {
			if($insertId=Transations::addExpense($input,Auth::user()->uid)) {
				return Redirect::to('printDebitVoucher/'.$insertId);
			}
			else {
				return Redirect::back()
					->withInput();
			}
		}		
		
	}
	public function addTransations() {
		$type=Input::get('type');
		$date=Input::get('date');
		$ref_no=Input::get('ref_no');
		$amount=Input::get('amount');
		$description=Input::get('description');
		$rules=array(
			'type'=>'required|in:expense,receipt',
			'type'=>'required|in:expense,receipt',
			'type'=>'required|in:expense,receipt',
			'type'=>'required|in:expense,receipt',
			'type'=>'required|in:expense,receipt',
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
			return Redirect::to('transations/expense')
				->withInput()
				->with('error','Invalid form token, Plsease try again');
		}

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

	public function printExpense($tid) {
		$trans= new Transations;
		$option['where']=array('transations.tid'=>$tid);
		$option['limit']='100';
		$data=$trans->getExpense(Auth::user()->uid,$option);
		if(count($data) < 1) {
			return Redirect::to("dashboard")
				->withErrors("Invalid transations Id");
		}
		$this->layout->title="";
		$this->layout->content=View::make('debitVoucher')
			->with('data',$data);
	}

	public function PrintDailyReport() {

		$rules=array(
			'dailyDate'=>'required|date_format:Y-m-d'
		);

		$messages =array(
			'dailyDate.date_format'=>'Invalid date format',
		);

		$validator = Validator::make(Input::all(),$rules,$messages);

		if($validator->fails()) {
			return Redirect::back()
				->withInput()
				->withErrors($validator);
		}

		$date=Input::get('dailyDate');
		$trans= new Transations;
		$option['where']=array('transations.date'=>$date);
		$option['limit']=0;
		$data=$trans->searchTransation(Auth::user()->uid,$option);

		$closingBalance=$trans->closingBalance(Auth::user()->uid,$date);
		$openingBalance=$trans->openingBalance(Auth::user()->uid,$date);
		$this->layout->title="";
		$this->layout->content=View::make('dailyReport')
			->with('data',$data)
			->with('date',$date)
			->with('openingBalance',$openingBalance)
			->with('closingBalance',$closingBalance);
	}

	public function deleteExpense($tItemId) {

		$row=DB::table('transations_item')			
			->leftJoin('transations','transations_item.tid','=','transations.tid')
			->where('transations.date','=',date('Y-m-d'))
			->where('transations_item.t_item_id','=',$tItemId)
			->first();

		if($row) {
			try {
				DB::table('transations_item')			
				->where('t_item_id','=',$tItemId)
				->delete();
				$return=array('1','Transation Deleted successfully');
				return $return;
			}
			catch(Exception $e) {
				$return=array('0','First delete all Expense Transations before delete this transation',$e->getMessage());
				return $return;
			}
			
		}
		else {
			$return=array('0','tring to delete Invalid transation');
			return $return;
		}
	}

}