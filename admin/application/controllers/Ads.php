<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ads extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $data['listing'] = $this->panamerico_model->listing('ads', 'ad_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'ad_name' => $this->input->get('search'),
            'ad_id' => $this->input->get('search'),
                ), array(
            'ad_status' => $this->input->get('status')
        ));

        $total_rows = $this->panamerico_model->contall('ads', array(
            'ad_name' => $this->input->get('search'),
            'ad_id' => $this->input->get('search'),
                ), array(
            'ad_status' => $this->input->get('status')
        ));
        $data['total'] = $total_rows;
        $this->template->load('system', 'ads', $data);
    }

    public function status() {
        if ($this->input->post('acao') == 'ok') {
            $this->panamerico_model->alteraStatus($this->input->post('ad_id'), $this->input->post('status'), $this->input->post('status_atual'));
            echo json_encode(array('sucess' => 'ok'));
        } elseif ($this->input->post('acao') == 'massa') {
            $this->panamerico_model->alteraStatusEmMassa($this->input->post('status_id'), $this->input->post('status_atual'));
            echo json_encode(array('sucess' => 'ok'));
        } elseif ($this->input->post('acao') == 'excluir') {
            //exclue permanentemente os anuncios selecionados..
            $this->panamerico_model->excluirAds($this->input->post('ad_id'), $this->input->post('status'));
            echo json_encode(array('sucess' => 'ok'));
        } elseif ($this->input->post('acao') == 'excluirmassa') {
            //exclue permanentemente os anuncios com status = 5
            $this->panamerico_model->excluirAdsEmMassa($this->input->post('status_id'), $this->input->post('status_atual'));
            echo json_encode(array('sucess' => 'ok'));
        }
    }

    public function edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('ads', 'ad_id', $code);

        if ($data['item']->ad_use_info) {

            $regions = $this->main_model->regionsDetails($data['item']->use_region);
            $regions = @$regions->regiao_nome;
            $data['region'] = $regions;
        } else {

            $regions = $this->main_model->regionsDetails($data['item']->ad_region);
            $regions = @$regions->regiao_nome;
            $data['region'] = $regions;
        }

        $data['categories'] = $this->panamerico_model->listingByWhere('ads_categories', 'ads_cat_parent', 0);
        $data['category_secondary'] = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $data['item']->ads_cat_id);
        $data['category_primary'] = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $data['category_secondary']->ads_cat_parent);

        $data['images'] = $this->panamerico_model->listingByWhere('ads_images', 'ad_id', $code);

        $data['areas'] = $this->panamerico_model->listing('areas', 'area_name', 'ASC');

        $data['states'] = $this->panamerico_model->listing('states', 'sta_name', 'ASC');

        $this->template->load('system', 'ads_form', $data);
    }

    public function save() {
        $e = $this->input->post("e");

        $name = $this->input->post("name");
        $status = $this->input->post("status");
        $category = $this->input->post("category");
        $desc = $this->input->post("desc");
        $price = $this->input->post("price");
        $service = $this->input->post("service");
        $trade = $this->input->post("trade");
        $areas = $this->input->post("areas[]");
        $video = $this->input->post("video");
        $elo7 = $this->input->post("elo7");
        $mercado_livre = $this->input->post("mercado_livre");
        $user_info = $this->input->post("user_info");
        $cep = $this->input->post("cep");
        $address = $this->input->post("address");
        $city = $this->input->post("city");
        $state = $this->input->post("state");
        $region = $this->input->post("region");
        $neighborhood = $this->input->post("neighborhood");
        $custom = $this->input->post("custom[]");
        $custom_checkbox = $this->input->post("custom_checkbox[]");

        $data = array(
            'ad_name' => $name,
            'ad_status' => $status,
            'ads_cat_id' => $category,
            'ad_price' => $price,
            'ad_service' => $service,
            'ad_trade' => $trade,
            'ad_video' => $video,
            'ad_elo7' => $elo7,
            'ad_mercado_livre' => $mercado_livre,
            'ad_use_info' => (($user_info) ? 1 : 0),
            'ad_cep' => $cep,
            'ad_address' => $address,
            'ad_city' => $city,
            'ad_state' => $state,
            'ad_neighborhood' => $neighborhood,
            'ad_region' => $region
        );

        if ($e) {
            $this->panamerico_model->update('ads', 'ad_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('ads', $data);
        }

        $this->panamerico_model->delete('ads_areas', 'ad_id', $code);

        if ($areas) {
            foreach ($areas as $key => $area) {
                $data = array('area_id' => $area, 'ad_id' => $e);

                $this->panamerico_model->insert('ads_areas', $data);
            }
        }
        
        
        if($e){
			
			$this->ads_model->cleanCustomFields($e);

			if($custom){
				foreach ($custom as $key => $custom_item) {
					$custom_data = array(
						'ad_id' => $e, 
						'cat_fie_id' => $key, 
						'ads_cus_value' => $custom_item
					);

					$this->ads_model->insertCustomField($custom_data);
				}
			}

			$this->ads_model->cleanCustomCheckbox($e);

			if($custom_checkbox){
				foreach ($custom_checkbox as $key_1 => $checkbox_item) {
					foreach ($checkbox_item as $key_2 => $custom_item) {
						$custom_data = array(
							'ad_id' => $e, 
							'cat_fie_id' => $key_1, 
							'che_opt_id' => $key_2
						);

						$this->ads_model->insertCustomCheckbox($custom_data);
					}
				}
			}
                        
                       
                       

		}
        

        $this->session->set_flashdata('return', 'save');

        redirect("ads");
    }

    public function modalStatus($status_id, $btn, $status_atual) {

        $data['modal_title'] = $btn . ' Anúncio';
        $data['modal_text'] = "Você tem certeza que deseja $btn anúncio?";
        $data['status_id'] = $status_id;
        $data['status_atual'] = $status_atual;
        $data['modal_link_type'] = 'success';
        $data['modal_link_text'] = $btn;

        $this->template->load('modal', 'status', $data);
    }

    public function approve($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Aprovar Anúncio";
            $data['modal_text'] = "Você tem certeza que deseja aprovar esse anúncio?";
            $data['modal_link_href'] = base_url('ads/approve/action/' . $code.'/?status='.$_GET['status']);
            $data['modal_link_type'] = 'success';
            $data['modal_link_text'] = 'Aprovar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $item = $this->panamerico_model->details('ads', 'ad_id', $code);
            $user = $this->panamerico_model->details('users', 'use_id', $item->use_id);

            /* Email Variables */
            $name = $user->use_name;
            $email = $user->use_email;
            $ad_name = $item->ad_name;
            $ad_link = "http://www.seusite.com.br" . str_replace(ADMIN_PATH, "", base_url('anuncio/' . $item->ad_slug));
            $datetime = date('d/m/Y H:i:s');

            /* Email Details */
            $email_details = $this->panamerico_model->details('emails', 'email_id', 12);

            /* Message */
            $content = $email_details->email_content;

            if (preg_match_all('/({\$+\w+})/', $content, $matches)) {

                foreach ($matches[0] as $key => $value) {
                    $variable = str_replace('{', '', $value);
                    $variable = str_replace('}', '', $variable);
                    $string = eval('return ' . $variable . ';');

                    $content = str_replace($value, $string, $content);
                }
            }

            $email_message = $content;

            /* Subject */
            $email_subject = $email_details->email_subject;

            /* To */
            $email_to = $email;

            /* Send Email */
            $this->panamerico_model->email($email_to, $email_subject, $email_message);

            $data = array('ad_status' => 2);

            $this->panamerico_model->update('ads', 'ad_id', $code, $data);

            $this->session->set_flashdata('return', 'save');
            if($this->input->get('status') > 0){
              redirect('ads/?status='.$this->input->get('status'));
            }
            redirect('ads');
            
        }
    }

    public function delete($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Anúncio";
            $data['modal_text'] = "Você tem certeza que deseja apagar esse anúncio?";
            $data['modal_link_href'] = base_url('ads/delete/action/' . $code);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $item = $this->panamerico_model->details('ads', 'ad_id', $code);
            $user = $this->panamerico_model->details('users', 'use_id', $item->use_id);

            /* Email Variables */
            $name = $user->use_name;
            $email = 'wandes2030@gmail.com';
            $ad_name = $item->ad_name;
            $datetime = date('d/m/Y H:i:s');

            /* Email Details */
            $email_details = $this->panamerico_model->details('emails', 'email_id', 10);

            /* Message */
            $content = $email_details->email_content;

            if (preg_match_all('/({\$+\w+})/', $content, $matches)) {

                foreach ($matches[0] as $key => $value) {
                    $variable = str_replace('{', '', $value);
                    $variable = str_replace('}', '', $variable);
                    $string = eval('return ' . $variable . ';');

                    $content = str_replace($value, $string, $content);
                }
            }

            $email_message = $content;

            /* Subject */
            $email_subject = $email_details->email_subject;

            /* To */
            $email_to = $email;

            /* Send Email */
            $this->panamerico_model->email($email_to, $email_subject, $email_message);

            // $this->panamerico_model->delete('ads', 'ad_id', $code);
            //$this->panamerico_model->deleteIMG($code);

            $this->session->set_flashdata('return', 'delete');

            redirect('ads');
        }
    }

    public function categoriesSecondary($category) {
        $categories = $this->panamerico_model->listingByWhere('ads_categories', 'ads_cat_parent', $category);

        foreach ($categories as $key => $cat) {
            echo '<option value="' . $cat->ads_cat_id . '">' . $cat->ads_cat_name . '</option>';
        }
    }

    public function images_delete($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Imagem";
            $data['modal_text'] = "Você tem certeza que deseja apagar essa imagem?<br><br><strong>Atenção!</strong> Essa ação irá apagar a imagem e não terá como voltar a ação.";
            $data['modal_link_href'] = base_url('ads/images_delete/action/' . $code);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $image = $this->panamerico_model->details('ads_images', 'ads_img_id', $code);

            unlink($image->ads_img_path);

            $this->panamerico_model->delete('ads_images', 'ads_img_id', $code);

            $this->session->set_flashdata('return', 'delete');

            redirect('ads/edit/' . $image->ad_id);
        }
    }

    public function areas() {
        $data['listing'] = $this->panamerico_model->listing('areas', 'area_name', 'ASC');

        $this->template->load('system', 'ads_areas', $data);
    }

    public function areas_insert() {
        $data['e'] = false;

        $this->template->load('system', 'ads_areas_form', $data);
    }

    public function areas_edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('areas', 'area_id', $code);

        $this->template->load('system', 'ads_areas_form', $data);
    }

    public function areas_save() {
        $e = $this->input->post("e");

        $name = $this->input->post("name");
        $status = $this->input->post("status");

        $data = array(
            'area_name' => $name,
            'area_status' => $status
        );

        if ($e) {
            $this->panamerico_model->update('areas', 'area_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('areas', $data);
        }

        $this->session->set_flashdata('return', 'save');

        redirect("ads/areas");
    }

    public function areas_delete($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Área";
            $data['modal_text'] = "Você tem certeza que deseja apagar essa área?";
            $data['modal_link_href'] = base_url('ads/areas_delete/action/' . $code);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $this->panamerico_model->delete('areas', 'area_id', $code);

            $this->session->set_flashdata('return', 'delete');

            redirect('ads/areas');
        }
    }

    public function cities($state) {
        $cities = $this->panamerico_model->listingByWhere('cities', 'sta_id', $state);

        foreach ($cities as $key => $city) {
            echo '<option value="' . $city->cit_id . '">' . $city->cit_name . '</option>';
        }
    }

}

/* End of file Ads.php */
/* Location: ./application/controllers/Ads.php */