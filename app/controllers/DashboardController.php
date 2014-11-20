<?php



/**
 * UsersController Class
 *
 * Implements actions regarding user management
 */
class DashboardController extends BaseController
{
	protected $layout = 'layouts.master';

	public function index() {
		$this->layout->title="Wellcome to dashboard";
		$data['today_in']=Transations::total_today_in();
		$data['month_in']=Transations::total_month_in();
		$data['today_out']=Transations::total_today_out();
		$data['month_out']=Transations::total_month_out();
		$data['transations']=Transations::take(10)
			->orderby('tid','desc')
			->get();
		$this->layout->content = View::make('dashboard')
			->with('data',$data);
	}
}
