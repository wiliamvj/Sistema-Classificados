<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Errors extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function e404()
	{
		/* Breadcrumbs */
		$data['breadcrumbs'][] = array('name' => 'Página Não Encontrada');

		/* SEO */
		$data['seo_title'] = "Página Não Encontrada";

		/* View */
		$this->template->load('app', 'errors_e404', $data);
	}

}

/* End of file Errors.php */
/* Location: ./application/controllers/Errors.php */