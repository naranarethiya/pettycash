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
		$this->layout->title="Add Expense";
		$this->layout->content = View::make('transation');
	}
}
