<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		if(!$this->session->userdata("login")){
			
			$this->session->set_flashdata('return', 'login_required');

			redirect('login');
		}
	}

}

/* End of file MY_Controller.php */
/* Location: ./application/controllers/MY_Controller.php */