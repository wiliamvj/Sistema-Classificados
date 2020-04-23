<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		redirect('ads');
	}

}

/* End of file Dashboard.php */
/* Location: ./application/controllers/Dashboard.php */