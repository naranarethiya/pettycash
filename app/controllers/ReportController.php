<?php

class ReportController extends BaseController
{
	protected $layout = 'layouts.master';

	public function index() {
		$this->layout->title="Transaction Reporting";
		$this->layout->content = View::make('report');
	}
}