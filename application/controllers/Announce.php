<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Announce extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        /* Hash */
        $ip = $_SERVER['REMOTE_ADDR'];
        $data['hash'] = md5($ip . rand(1, 999));

        /* Categories */
        $data['categories'] = $this->ads_model->categories(0);

        /* Areas */
        $data['user'] = $this->user_model->info();

        /* Breadcrumbs */
        $data['breadcrumbs'][] = array('name' => 'Inserir Anúncio');

        /* SEO */
        $data['seo_title'] = "Inserir Anúncio";

        if (empty($data['user']->use_cep)):
            $data['modal_alert'] = base_url('announce/ads_action/modal/user');
            $data['form_disabled'] = true;
        endif;

        /* View */
        $this->template->load('app', 'announce', $data);
    }

    public function ads_action($view, $action) {

        if ($action == "user") {
            $data['modal_title'] = "<p style=\"text-align: center; font-size: 30px; padding-left: 80px;\">Ops!</p>";
            $data['text'] = 'Para inserir um anúncio você precisa completar seu cadastro!<br>É rapidinho ;)';
            $data['link'] = base_url('cliente/detalhes/');
            $data['button'] = array('type' => 'warning', 'text' => 'Completar');
        } elseif ($action == "resell") { /* Resell */
            $data['modal_title'] = "Revender Anúncio";

            $data['text'] = 'Você tem certeza que deseja revender o anúncio "<strong></strong>"?';

            $data['button'] = array('type' => 'secondary', 'text' => 'Revender');
        }

        $data['modal_size'] = "small";

        $this->template->load('modal', 'alert', $data);
    }

    public function insert() {
        $hash = $this->input->post("hash");

        $category = (int) $this->input->post("category");
        $title = $this->input->post("title");
        $desc = $this->input->post("desc");
        $price = $this->input->post("price");
        $service = $this->input->post("no-price");
        $trade = $this->input->post("yes-trade");
        $video = $this->input->post("video");
        $areas = $this->input->post("area");
        $mercado_livre = $this->input->post("mercado_livre");
        $elo7 = $this->input->post("elo7");
        $cep = $this->input->post("cep");
        $state = $this->input->post("state");
        $region = $this->input->post("region");
        $city = $this->input->post("city");
        $neighborhood = $this->input->post("neighborhood");
        $address = validate_name($this->input->post("address"));
        $use_info = $this->input->post("use-info");
        $custom = $this->input->post("custom[]");
        $custom_checkbox = $this->input->post("custom_checkbox[]");
        $adote = $this->input->post("adote");

        $slug = strip_accents(url_title($title . "-" . rand(1, 999)));

        $data = array(
            'adote' => (($adote) ? 1 : 0),
            'ads_cat_id' => $category,
            'use_id' => $this->session->userdata('login'),
            'ad_name' => $title,
            'ad_desc' => $desc,
            'ad_price' => db_money($price),
            'ad_service' => (($service) ? 1 : 0),
            'ad_trade' => (($trade) ? 1 : 0),
            'ad_video' => $video,
            'ad_mercado_livre' => $mercado_livre,
            'ad_elo7' => $elo7,
            'ad_cep' => (($cep) ? $cep : ""),
            'ad_state' => (($state) ? $state : ""),
            'ad_region' => (($region) ? $region : ""),
            'ad_city' => (($city) ? $city : ""),
            'ad_neighborhood' => (($neighborhood) ? $neighborhood : ""),
            'ad_address' => (($address) ? $address : ""),
            'ad_use_info' => (($use_info) ? 1 : 0),
            'ad_slug' => $slug,
            'ad_status' => 1
        );

        $ad = $this->ads_model->insert($data);

        if ($ad) {
            /* Set Images */
            $this->ads_model->imagesSetAds($hash, $ad);
            $this->ads_model->cleanImagesHashs($ad);

            /* Set Custom Fields */
            if ($custom) {
                foreach ($custom as $key => $custom_item) {
                    $custom_data = array(
                        'ad_id' => $ad,
                        'cat_fie_id' => $key,
                        'ads_cus_value' => $custom_item
                    );

                    $this->ads_model->insertCustomField($custom_data);
                }
            }

            if ($custom_checkbox) {
                foreach ($custom_checkbox as $key_1 => $checkbox_item) {
                    foreach ($checkbox_item as $key_2 => $custom_item) {
                        $custom_data = array(
                            'ad_id' => $ad,
                            'cat_fie_id' => $key_1,
                            'che_opt_id' => $key_2
                        );

                        $this->ads_model->insertCustomCheckbox($custom_data);
                    }
                }
            }

            /* Variables */
            $user = $this->user_model->info();
            $user_name = $user->use_name;
            $user_email = $user->use_email;
            $ad_name = $title;
            $datetime = date('d/m/Y H:i:s');

            /* Email Details */
            $email_details = $this->main_model->emailsDetails(8);

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
            $email_to = $user_email;

            /* Send Email */
            $this->main_model->email($email_to, $email_subject, $email_message);

            $this->session->set_flashdata('return', 'announce_insert_success');
        }

        redirect("cliente/painel");
    }

    public function categories() {
        $parent = $this->input->post("category");

        $categories = $this->ads_model->categories($parent);

        if ($categories) {
            echo '<ul>';

            foreach ($categories as $key => $cat) {
                echo '<li data-id="' . $cat->ads_cat_id . '">' . $cat->ads_cat_name . '</li>';
            }

            echo '</ul>';
        } else {
            echo '<small>Não existe subcategorias para essa categoria.</small>';
        }
    }

    private function isTamanho($campo) {
        if (strlen($_FILES[$campo]['name']) > 0) {
            $logo = $_FILES[$campo]['tmp_name'];
            list($largura, $altura) = getimagesize($logo);
            if ($largura < 350 and $altura < 260) {
                return FALSE;
            }
        }
        return TRUE;
    }

    public function images_upload($hash) {
        if ($this->isTamanho('file')) {
            $upload = $this->main_model->uploadImage('file', 'ads');
            if (strlen($upload['file_name'])) {
                $data = array(
                    'ad_hash' => $hash,
                    'ads_img_path' => $upload['full_path'],
                    'ads_img_file' => $upload['file_name']
                );

                $image = $this->ads_model->imagesInsert($data);

                echo $image;
            }
        } else {
            echo 'error';
        }
    }

    public function images_remove() {
        $image_id = $this->input->post('image');

        $image = $this->ads_model->imagesDetails($image_id);

        $this->ads_model->imagesDelete($image_id);

        unlink($image->ads_img_path);
    }

    public function preview_images() {
        $hash = $this->input->post('hash');

        $images = $this->ads_model->images($hash, true);

        if ($images) {
            echo '
			<div class="ap-images">
				<div class="ap-i-master">
			';

            foreach ($images as $key => $image) {
                $w = 740;
                $h = 400;

                echo '<img data-image="' . $image->ads_img_id . '" ' . (($key == 0) ? 'class="active"' : '') . ' src="' . thumbnail(@$image->ads_img_file, "ads", $w, $h, 2) . '">';
            }

            echo '
				</div>
			';

            if (count($images) > 1) {
                echo '
					<div class="ap-i-controls">
						<div class="ap-ic-btn"><span id="ap-ic-prev"><i class="fa fa-chevron-left"></i></span></div>
						<div class="ap-ic-btn"><span id="ap-ic-next"><i class="fa fa-chevron-right"></i></span></div>
					</div>
					<div class="ap-i-slider" id="ap-i-slider">
				';

                foreach ($images as $key => $image) {
                    echo '
						<div data-image="' . $image->ads_img_id . '" class="item">
							<img src="' . thumbnail(@$image->ads_img_file, "ads", 200, 150, 2) . '">
						</div>
					';
                }

                echo '
					</div>
				';
            }

            echo '</div>';
        } else {
            echo '
				<div class="ap-images">
					<div class="ap-i-master">
						<img class="active" src="' . thumbnail(false, false, 740, 400) . '">
					</div>
				</div>
			';
        }
    }

}

/* End of file Announce.php */
/* Location: ./application/controllers/Announce.php */