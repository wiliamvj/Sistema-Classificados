<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		/* SEO */
		$data['seo_title'] = "Site em Manutenção";

		/* View */
		$this->template->load('external', 'maintenance', $data);
	}

}

/* End of file Maintenance.php */
/* Location: ./application/controllers/Maintenance.php */