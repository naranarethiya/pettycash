<?php

class bankBookController extends BaseController {
	protected $layout = 'layouts.master';

	public function index() {
		$this->layout->title="Add Bank Transactions";
		$this->layout->content = View::make('bankBookAdd');
		$bankBook=new BankBook;
		$bankCombo=UserBanks::bankCombo(Auth::user()->uid);
		$data=$bankBook->search(Auth::user()->uid,array('limit'=>'10'));
		$this->layout->content = View::make('bankBookAdd')
			->with('data',$data)
			->with('bankCombo',$bankCombo);
	}


	public function add() {
		$bankBook=new BankBook;
		$bankIds=keysImplode(UserBanks::bankCombo(Auth::user()->uid,false));
		$rules=array(
			'source'=>'required',
			'bid'=>'required|in:'.$bankIds,
			'amount'=>'required|numeric|min:1',
			'date'=>'required|date_format:Y-m-d',
			'type'=>'required|in:debit,credit'
		);
		$messages=array(
			'source.required'=>'Source/Pay to is required',
			'date.date_format'=>'Invalid date format, format must YYYY-MM-DD',
			'amount.min' => 'Expense Amount not less than one',
			'bid.in'=>'Invalid Bank selected',
			'type.in'=>'Invalid transaction type'
		);

		$validator=Validator::make(Input::all(),$rules,$messages);
		if($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->withInput();
		}
		if($bankBook->addTransation(Auth::user()->uid,Input::all())) {
			return Redirect::back()
			->with('success',"Transaction Saved successfully");	
		}
		return Redirect::back();
	}

	public function delete($id) {
		$data=array();
		try {
			DB::table('bank_book')
			->where('id',$id)
			->where('uid',Auth::user()->uid)
			->update(array('deleted_at'=>date('Y-m-d h:i:s')));	
			$data[0]="1";
			$data[1]="Transaction Deleted";
		}
		catch(Exception $e) {
			$data[0]="0";
			$data[1]=$e->getMessage();
		}
		return $data;
	}

	public function seachResult() {

		$rules=array(
			'source'=>'min:3',
			'from'=>'date_format:Y-m-d',
			'to'=>'date_format:Y-m-d',
			'amount'=>'numeric',
			'payment_type'=>'in:credit,debit'
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
		$bankBook = new BankBook;
		$data['transations']=$bankBook->search(Auth::user()->uid,Input::all());
		if(Input::get('submit')=='export') {
			$arrFirstRow = array('Transation id','Date','Transaction Type','Source/ Pay to','Bank','Amount','Reference Number','Note');
			$arrColumns = array('id', 'date','type', 'source', 'bank', 'amount','ref_no','note');

			$options = array(
				'columns' => $arrColumns,
				'firstRow' => $arrFirstRow,
			);
			$Files = new GlobalHelper;
  			return $Files->convertToCSV($data['transations'], $options);
		}

		$bankCombo=UserBanks::bankCombo(Auth::user()->uid);
		$this->layout->title="Bankbook Search Result";
		$this->layout->content=View::make('bankBookSearchResult')
			->with('bankCombo',$bankCombo)
			->with('data',$data)
			->withInput(Input::all());
	}

	public function searchForm() {
		$this->layout->title="Search Bank Transactions";
		$bankBook=new BankBook;
		$bankCombo=UserBanks::bankCombo(Auth::user()->uid);
		$this->layout->content=View::make('searchPage')
			->with('bankCombo',$bankCombo)
			->with('loadForm','bankBookSearchForm')
			->with('title','Search Bankbook Transactions');
	}

	public function export() {

	}

}