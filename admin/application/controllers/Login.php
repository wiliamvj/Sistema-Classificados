<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		if($this->session->userdata('login')){
			redirect('/');
		}
		
		/* View */
		$this->template->load('login', 'index');
	}

	public function in()
	{
		$user = $this->input->post('user');
		$pass = md5($this->input->post('pass'));

		$login = $this->panamerico_model->login($user, $pass);

		if($login){			
			$this->session->set_userdata('login', $login);

			$this->session->set_flashdata('return', 'login_success');

			redirect('/');
		}else{
			$this->session->set_userdata('login', false);

			$this->session->set_flashdata('return', 'login_error');

			redirect("login");
		}
	}

	public function out()
	{
		/* session destroy */
		$this->session->set_userdata('login', false);
		$this->session->sess_destroy();

		redirect("/");
	}

}

/* End of file Login.php */
/* Location: ./application/controllers/Login.php */