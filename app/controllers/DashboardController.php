<?php

class DashboardController extends BaseController
{
	protected $layout = 'layouts.master';

	public function index() {
		$this->layout->title="Welcome to Dashboard";
		$data['today_in']=Transations::total_today_in(Auth::user()->uid);
		$data['month_in']=Transations::total_month_in(Auth::user()->uid);
		$data['today_out']=Transations::total_today_out(Auth::user()->uid);
		$data['month_out']=Transations::total_month_out(Auth::user()->uid);
		$trans=new Transations;
		$to=date('Y-m-d');
		$from = subDate($to,'7','D');
		$sumExpense=$trans->getSumTransation(Auth::user()->uid,'expense',$from,$to);
		$sumReceipt=$trans->getSumTransation(Auth::user()->uid,'receipt',$from,$to);

		$data['chatData']=$this->createChartData($sumExpense,$sumReceipt);
		$trans=new Transations();
		/*$data['transations']=Transations::where('uid',Auth::user()->uid)
			->where('date',$to)
			->orderby('tid','desc')
			->get();*/
		$option['where']=array('date'=>$to);
		$data['transations']=$trans->searchTransation(Auth::user()->uid,$option);
		$this->layout->content = View::make('dashboard')
			->with('data',$data);
	}


	public function createChartData($expense,$receipt) {
		$expArray=array();
		$recArray=array();
		foreach($expense as $row) {
			$expArray[$row->date]=$row->total;
		}

		foreach($receipt as $row) {
			$recArray[$row->date]=$row->total;
		}
		$chartArray=array(array('Date','Receipt','Expense'));
		$to=date('Y-m-d');
		$from = subDate($to,'7','D');
		while($from <= $to) {
			if(!isset($expArray[$from])) {
				$expArray[$from]=0;
			}

			if(!isset($recArray[$from])) {
				$recArray[$from]=0;
			}
			$newDate= new dateTime($from);
			$newDate=$newDate->format('d M');
			$chartArray[]=array($newDate,$recArray[$from],$expArray[$from]);

			$from = addDate($from,'1','D');
		}
		return $chartArray;
	}
}
