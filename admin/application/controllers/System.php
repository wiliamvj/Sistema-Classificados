<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class System extends MY_Controller {



	public function __construct()

	{

		parent::__construct();

	}



	public function index()

	{

		$data['system'] = $this->panamerico_model->details('config', 'cfg_id', 1);



		$this->template->load('system', 'system', $data);

	}



	public function update()

	{

		$data = array(

			'cfg_seo_title' 	=> $this->input->post('seo_title'), 

			'cfg_seo_keywords' 	=> $this->input->post('seo_keywords'), 

			'cfg_seo_desc' 		=> $this->input->post('seo_desc'), 

			'cfg_contact_email' => $this->input->post('contact_email'),
			
			'cfg_slogan_pri' 	=> $this->input->post('slogan_pri'),
            
			'cfg_slogan_sec' 	=> $this->input->post('slogan_sec'),
	
			'cfg_slogan_mob' 	=> $this->input->post('slogan_mob'),

			'cfg_smtp_host' 	=> $this->input->post('smtp_host'), 

			'cfg_smtp_port' 	=> $this->input->post('smtp_port'), 

			'cfg_smtp_user' 	=> $this->input->post('smtp_user'), 

			'cfg_smtp_pass' 	=> $this->input->post('smtp_pass'),

			'cfg_social_facebook' => $this->input->post('social_facebook'),

			'cfg_social_google' => $this->input->post('social_google'),

			'cfg_social_twitter' => $this->input->post('social_twitter'),

			'cfg_social_linkedin' => $this->input->post('social_instagram'),

			'cfg_ads_count' => (($this->input->post('ads_count')) ? 1 : 0),

			'cfg_maintenance' => $this->input->post('maintenance'),

		);



		$this->panamerico_model->update('config', 'cfg_id', 1, $data);



		$this->session->set_flashdata('return', 'save');



		redirect('system');

	}



	public function users()

	{

		$data['listing'] = $this->panamerico_model->listing('admin_users', 'adm_use_login', 'ASC');



		$this->template->load('system', 'system_users', $data);

	}



	public function users_insert()

	{	

		$data['e'] = false;



		$this->template->load('system', 'system_users_form', $data);

	}



	public function users_edit($code)

	{

		$data['e'] = true;



		$data['item'] = $this->panamerico_model->details('admin_users', 'adm_use_id', $code);



		$this->template->load('system', 'system_users_form', $data);

	}



	public function users_save()

	{

		$e = $this->input->post("e");



		$login = strtolower($this->input->post("login"));

		$status = $this->input->post("status");

		$pass = $this->input->post("pass");

		$email = $this->input->post("email");



		$data = array(

			'adm_use_login' => $login,

			'adm_use_email' => $email,

			'adm_use_status' => $status

		);



		if($e){

			if($pass){

				$data['adm_use_pass'] = md5($pass);

			}



			$this->panamerico_model->update('admin_users', 'adm_use_id', $e, $data);

		}else{

			$data['adm_use_pass'] = md5($pass);



			$e = $this->panamerico_model->insert('admin_users', $data);

		}



		$this->session->set_flashdata('return', 'save');



		redirect("system/users");

	}



	public function users_delete($view = "modal", $code)

	{

		if($view == "modal"){

			$data['modal_title'] = "Apagar Usuário";

			$data['modal_text'] = "Você tem certeza que deseja apagar esse usuário?";

			$data['modal_link_href'] = base_url('system/users_delete/action/'.$code);

			$data['modal_link_type'] = 'danger';

			$data['modal_link_text'] = 'Apagar';



			$this->template->load('modal', 'default', $data);

		}



		if($view == "action"){

			$this->panamerico_model->delete('admin_users', 'adm_use_id', $code);



			$this->session->set_flashdata('return', 'delete');



			redirect('system/users');

		}

	}



}



/* End of file System.php */

/* Location: ./application/controllers/System.php */