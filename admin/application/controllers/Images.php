<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Images extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$config = array(
			"base_url" => base_url('images/page'),
			"per_page" => 50,
			"num_links" => 10,
			"uri_segment" => 3,
			"total_rows" => $this->panamerico_model->contall('ads_images'),
			"full_tag_open" => '<ul class="pagination">',
			"full_tag_close" => '</ul>',
			"first_link" => false,
			"last_link" => false,
			"first_tag_open" => '<li>',
			"first_tag_close" => '</li>',
			"prev_link" => "Anterior",
			"prev_tag_open" => '<li class="prev">',
			"prev_tag_close" => '</li>',
			"next_link" => "Proxima",
			"next_tag_open" => '<li class="next">',
			"next_tag_close" => '</li>',
			"last_tag_open" => '<li>',
			"last_tag_close" => '</li>',
			"cur_tag_open" => '<li class="active"><a href="#">',
			"cur_tag_close" => '</a></li>',
			"num_tag_open" => '<li>',
			"num_tag_close" => '</li>'

		);
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();

		$offset = ($this->uri->segment(3)) ? ($this->uri->segment(3)) : 0;

		$data['listing'] = $this->panamerico_model->listing('ads_images', 'ads_img_id', 'ASC', $config['per_page'], $offset);

		$this->template->load('system', 'images', $data);
	}

	public function delete($view = "modal", $code)
	{
		if($view == "modal"){
			$data['modal_title'] = "Apagar Imagem";
			$data['modal_text'] = "Você tem certeza que deseja apagar essa imagem?";
			$data['modal_link_href'] = base_url('images/delete/action/'.$code);
			$data['modal_link_type'] = 'danger';
			$data['modal_link_text'] = 'Apagar';

			$this->template->load('modal', 'default', $data);
		}

		if($view == "action"){
			$image = $this->panamerico_model->details('ads_images', 'ads_img_id', $code);

			unlink($image->ads_img_path);

			$this->panamerico_model->delete('ads_images', 'ads_img_id', $code);

			$this->session->set_flashdata('return', 'delete');

			redirect('images');
		}
	}

	public function insert()
	{
		if($_FILES['file']):
			$upload = null;
			if($_FILES['file']['error'] == UPLOAD_ERR_OK):
				$file = explode(".", $_FILES['file']['name']);
				$name = md5($_FILES['file']['name'].time());
				$upload = $name.'.'.$file[1];
				move_uploaded_file($_FILES['file']['tmp_name'], '/home/imagi092/public_html/admin/uploads/ads/'.$name.'.'.$file[1]);
			endif;
		endif;


		$data = array(
			'ads_img_path' => '/home/imagi092/public_html/admin/uploads/ads/'.$upload,
			'ads_img_file' => $upload,
		);

		$image = $this->main_model->imagesInsert($data);

		redirect('images');
	
	}

}

/* End of file Images.php */
/* Location: ./application/controllers/Images.php */