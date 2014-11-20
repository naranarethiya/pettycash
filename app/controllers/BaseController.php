<?php

class BaseController extends Controller {

	public function __construct()  {
		//View::share('cash_in_hand',Balance::get_balance());
	}
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected $layout='layouts.master';
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}
