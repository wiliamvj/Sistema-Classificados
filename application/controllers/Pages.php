<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pages extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->seo_title = "Ajuda";
	}

	public function index()
	{
		redirect('/');
	}

	public function details($code)
	{
		/* Page Details */
		$data['p'] = $this->main_model->pagesDetails($code);

		/* Page FAQ */
		$data['faq'] = $this->main_model->pagesFaq($code);

		/* Breadcrumbs */
		$data['breadcrumbs'][] = array('name' => $this->seo_title);
		$data['breadcrumbs'][] = array('name' => $data['p']->page_name);

		/* SEO */
		$data['seo_title'] = $data['p']->page_name." - ".$this->seo_title;

		/* View */
		$data['page'] = 'default';
		$this->template->load('app', 'pages', $data);
	}

	public function route($slug)
	{
		$page = $this->main_model->pageBySlug($slug);

		$this->details($page->page_id);
	}

	public function contact($view = "page")
	{
		if($view == "page"){
			/* Breadcrumbs */
			$data['breadcrumbs'][] = array('name' => $this->seo_title);
			$data['breadcrumbs'][] = array('name' => 'Contato');

			/* SEO */
			$data['seo_title'] = "Contato - ".$this->seo_title;

			/* View */
			$data['page'] = 'contact';
			$this->template->load('app', 'pages', $data);
		}elseif ($view == "send") {
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$phone = $this->input->post('phone');
			$subject = $this->input->post('subject');
			$msg = $this->input->post('msg');
			$datetime = date('d/m/Y H:i:s');

			/* Email Details */
			$email_details = $this->main_model->emailsDetails(3);

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

			$to = $this->main_model->config('cfg_contact_email');

			$this->main_model->email($to, $subject." | ".$email_subject, $message);

			$this->session->set_flashdata('return', 'contact_send');

			redirect('contato');
		}else{
			redirect('/');
		}
	}

}

/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */