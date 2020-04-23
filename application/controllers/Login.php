<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['modal_title'] = "Entrar";
		$data['modal_size'] = "small";

		$this->template->load('modal', 'login', $data);
	}

	public function required()
	{
		$data['modal_title'] = "Ops, você precisa efetuar o login";
		$data['modal_size'] = "small";

		$this->template->load('modal', 'login_required', $data);
	}

	public function in()
	{
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));

		$login = $this->user_model->login($email, $password);

		if($login){
			$this->session->set_userdata('login', $login);

			$data = array(
				'use_date_login' => date('Y-m-d H:i:s'),
				'use_last_ip' => $_SERVER['REMOTE_ADDR']
			);

			$this->user_model->update($data, $login);

			echo "login_success";
		}else{
			$this->session->set_userdata('login', false);

			echo "login_error";
		}
	}

	public function password($view = "modal", $token = false)
	{
		if($view == "modal"){
			$data['modal_title'] = "Esqueceu a senha?";
			$data['modal_size'] = "small";

			$this->template->load('modal', 'login_password', $data);
		}elseif ($view == "send") {
			$email = $this->input->post("email");

			$user = $this->user_model->getByEmail($email);

			if($user){
				$token = md5($_SERVER['REMOTE_ADDR'].date("H:i:s"));

				$data = array('use_token' => $token);

				$this->user_model->update($data, $user);

				$link = base_url("login/password/recover/".$token);

				/* Email Details */
				$email_details = $this->main_model->emailsDetails(2);

				/* Message */
				$content = $email_details->email_content;

				if (preg_match_all('/({\$+\w+})/', $content, $matches)){

					foreach ($matches[0] as $key => $value) {
						$variable = str_replace('{', '', $value);
						$variable = str_replace('}', '', $variable);
						$string = eval('return '. $variable . ';');

						$content = str_replace($value, $string, $content);
					}
				}

				$message = $content;

				/* Subject */
				$subject = $email_details->email_subject;

				$this->main_model->email($email, $subject, $message);

				$this->session->set_flashdata('return', 'login_password');
			}else{
				$this->session->set_flashdata('return', 'login_password_email');
			}

			redirect("/");
		}elseif ($view == "recover") {
			$verifyToken = $this->user_model->tokenVerify($token);

			if($verifyToken){
				$data['token'] = $token;

				/* SEO */
				$data['seo_title'] = "Recuperação de Senha";

				/* View */
				$this->template->load('app', 'login_password_recover', $data);
			}else{
				$this->session->set_flashdata('return', 'token_no_exist');

				redirect('/');
			}
		}elseif ($view == "update") {
			$new_pass = $this->input->post('new_pass');
			$token = $this->input->post('token');

			$this->user_model->passRecover($token, md5($new_pass));

			$this->session->set_flashdata('return', 'login_recover');

			redirect('/');
		}
	}

	public function facebook_auth($step)
	{
		$fb_config = array(
			'appId' 	=> $this->config->item('facebook_app_id'), 
			'secret' 	=> $this->config->item('facebook_app_secret')
		);

		$this->load->library('facebook', $fb_config);
				

		if($step == "try"){ // redirect to facebook form
			$facebook_login_url = $this->facebook->getLoginUrl(array(
				'redirect_uri' => $this->config->item('facebook_link_redirect'),
				'scope' => 'email'
			));

			redirect($facebook_login_url);
		}elseif ($step == "return") { // return from facebook form
			$user_facebook = $this->facebook->getUser();

			$code = $_GET['code'];

			if($user_facebook){
				$facebook_user_profile = $this->facebook->api('/me?fields=id,name,email');

				/* verify if user allow email */
				if($facebook_user_profile['email']){
					$id = $facebook_user_profile['id'];
					$name = validate_name($facebook_user_profile['name']);
					$email = $facebook_user_profile['email'];

					$verify = $this->user_model->getByEmail($email);

					/* verify if user already register */
					if($verify){ // login
						$user_id = $verify;
						
						$data = array('use_facebook_id' => $id);

						$this->user_model->update($data, $verify);

						$this->session->set_userdata('login', $verify);
					}else{ // register
						$data = array(
							'use_name' => $name, 
							'use_email' => $email, 
							'use_password' => md5($email),
							'use_facebook_id' => $id
						);

						$user = $this->user_model->insert($data);

						if($user){
							$user_id = $user;

							$this->session->set_userdata('login', $user);

							$this->session->set_flashdata('return', 'register_new');
						}
					}

					$log_data = array(
						'use_date_login' => date('Y-m-d H:i:s'),
						'use_last_ip' => $_SERVER['REMOTE_ADDR']
					);

					$this->user_model->update($log_data, $user_id);

					redirect('cliente/painel');
				}else{ // if email not allowed
					$this->session->set_flashdata('return', 'facebook_email_required');

					redirect('/');
				}
			}else{
				$this->session->set_flashdata('return', 'login_required');

				redirect('/');
			}
		}else{
			$this->out();
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