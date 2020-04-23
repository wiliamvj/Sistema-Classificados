<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data['modal_title'] = "Cadastre-se grátis";
		$data['modal_size'] = "small";

		$this->template->load('modal', 'register', $data);
	}

	public function insert()
	{
		$name = validate_name($this->input->post('name'));
		$email = $this->input->post('email');
		$password = md5($this->input->post('password'));

		$data = array(
			'use_name' => $name, 
			'use_email' => $email, 
			'use_password' => $password
		);

		$user = $this->user_model->insert($data);

		if($user){
			/* Email Details */
			$email_details = $this->main_model->emailsDetails(7);

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
			$email_subject = $email_details->email_subject;

			/* To */
			$to = $email;

			/* Send Email */
			$this->main_model->email($to, $email_subject, $message);

			/* Login */
			$this->session->set_userdata('login', $user);

			/* Return Msg */
			$this->session->set_flashdata('return', 'register_new');
		}

		redirect('profile/dashboard');
	}

	public function emailVerify()
	{
		$email = $this->input->post('email');

		$verifyEmail = $this->user_model->emailVerify($email);

		if($verifyEmail){
			echo 'email_registered';
		}else{
			echo 'email_free';
		}
	}

}

/* End of file Register.php */
/* Location: ./application/controllers/Register.php */