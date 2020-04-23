<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ads extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($page = false) {
        $preco = $this->filtroPreco($this->input->get('preco'));
        paginacao()->config(30);
        $ads = $this->ads_model->listing(false, paginacao()->getQtd(), paginacao()->getInicio(), array(
            'ads.ad_name' => $this->input->get('search')
                ), array(
            'ads.ad_price >=' => $preco[0],
            'ads.ad_price <=' => $preco[1],
            'ads.ad_state' => $this->input->get('estado'),
            'ads.ad_trade' => ($this->input->get('tipo') == 'trade') ? '1' : '',
            'ads.ad_service' => ($this->input->get('tipo') == 'service') ? '1' : '',
            'ads.ad_region' => $this->input->get('regiao'),
            'ads.ad_city' => $this->input->get('cidade')), array(
            'ads.ads_cat_id' => $this->input->get('categoria')
        ));
        $total_rows = $this->ads_model->contallAds(array(
            'ads.ad_name' => $this->input->get('search')
                ), array(
            'ads.ad_price >=' => $preco[0],
            'ads.ad_price <=' => $preco[1],
            'ads.ad_state' => $this->input->get('estado'),
            'ads.ad_trade' => ($this->input->get('tipo') == 'trade') ? '1' : '',
            'ads.ad_service' => ($this->input->get('tipo') == 'service') ? '1' : '',
            'ads.ad_region' => $this->input->get('regiao'),
            'ads.ad_city' => $this->input->get('cidade')
                ), array(
            'ads.ads_cat_id' => $this->input->get('categoria')
        ));
        $this->listing($ads, FALSE, $total_rows, false);
    }

    public function filtroPreco($preco) {
        $p = explode('_', $preco);
        return $p;
    }

    public function category($code) {
        $this->session->set_flashdata('ads_filter_category', $code);

        redirect('anuncios');
    }

    public function state($slug) {
        
    }

    public function listing($ads, $data = false, $total_rows, $ajax = FALSE) {

        $data['ads'] = $ads;
        $data['total'] = $total_rows;
        $data['categories'] = $this->ads_model->categories(0);
        $data['breadcrumbs'][] = array('name' => 'Anúncios');
        $data['seo_title'] = "Anúncios";

        $data['estado'] = $this->ads_model->listaFiltro('states', 'sta_name', 'ASC', array('sta_id', 'sta_name'));
        if (strlen($this->input->get('estado')) > 0) {
            $data['regiao'] =  $this->address_model->getRegions($this->input->get('estado'));
        }
        if (strlen($this->input->get('regiao')) > 0) {
            $data['cidade'] = $this->ads_model->listaFiltro('cities', 'cit_name', 'ASC', array('cit_id', 'cit_name'), array(
                'regiao_id' => $this->input->get('regiao')
            ));
        }

        $this->template->load('app', 'ads', $data);
    }

    public function details($code) {
        /* Details */
        $data['ad'] = $this->ads_model->details($code);

        if ($data['ad']) {

            if ($data['ad']->ad_use_info) {
                $state = $this->main_model->statesDetails($data['ad']->use_state);
                $regions = $this->main_model->regionsDetails($data['ad']->use_region);
                $city = $this->main_model->citiesDetails($data['ad']->use_city);

                $city = @$city->cit_name;
                $regions = @$regions->regiao_nome;
                $state = @$state->sta_name;

                $data['state'] = $state;
                $data['region'] = $regions;
                $data['city'] = $city;
                $data['neighborhood'] = $data['ad']->use_neighborhood;
                $data['address'] = $data['ad']->use_address;
                $data['cep'] = $data['ad']->use_cep;
            } else {
                $state = $this->main_model->statesDetails($data['ad']->ad_state);
                $regions = $this->main_model->regionsDetails($data['ad']->ad_region);
                $city = $this->main_model->citiesDetails($data['ad']->ad_city);

                $city = @$city->cit_name;
                $regions = @$regions->regiao_nome;
                $state = @$state->sta_name;

                $data['state'] = $state;
                $data['region'] = $regions;
                $data['city'] = $city;
                $data['neighborhood'] = $data['ad']->ad_neighborhood;
                $data['address'] = $data['ad']->ad_address;
                $data['cep'] = $data['ad']->ad_cep;
            }

            /* Images */
            $data['images'] = $this->ads_model->images($code);
            $data['main_image'] = thumbnail(@$data['images'][0]->ads_img_file, "ads", 740, 400);

            $data['custom_fields'] = $this->ads_model->customFields($code);

            //$data['custom_checkboxs'] = $this->ads_model->customCheckboxs($code);

            /* Parent Category */
            $data['category_parent'] = $this->ads_model->categoriesDetails($data['ad']->ads_cat_parent);

            /* Verify Shop */
            $data['shop'] = $this->shops_model->slug($data['ad']->use_id);

            if ($data['shop']) {
                $data['ads_shop'] = count($this->shops_model->ads($data['ad']->use_id));
            } else {
                $data['ads_shop'] = false;
            }

            /* Related Ads */
            $data['related'] = $this->ads_model->related(8, $code);

            /* Ad Link */
            $data['link'] = base_url('anuncio/' . $data['ad']->ad_slug);

            /* Breadcrumbs */
            $data['breadcrumbs'][] = array('name' => 'Anúncios', 'link' => base_url('anuncios'));
            $data['breadcrumbs'][] = array('name' => $data['category_parent']->ads_cat_name);
            $data['breadcrumbs'][] = array('name' => $data['ad']->ads_cat_name);
            $data['breadcrumbs'][] = array('name' => $data['ad']->ad_name);

            /* Record Visit */
            $visits = (int) $data['ad']->ad_visits;
            $new_visit = $visits + 1;
            $this->ads_model->recordVisit($data['ad']->ad_id, $new_visit);

            /* SEO */
            $data['seo_title'] = $data['ad']->ad_name . " - Anúncios";


            /* View */
            $this->template->load('app', 'ads_details', $data);
        } else {
            /* SEO */
            $data['seo_title'] = "Anúncio não Disponível - Anúncios";

            /* View */
            $this->template->load('app', 'ads_details_denied', $data);
        }
    }

    public function route($slug) {
        $ad = $this->ads_model->getBySlug($slug);

        $this->details($ad->ad_id);
    }

    public function send_message() {
        /* Post */
        $code = $this->input->post('code');
        $name = validate_name($this->input->post('name'));
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $msg = $this->input->post('msg');

        /* Ad Details */
        $ad = $this->ads_model->details($code);
        $ad_name = $ad->ad_name;
        $ad_link = base_url('anuncio/' . $ad->ad_slug);

        /* Email Details */
        $email_details = $this->main_model->emailsDetails(1);

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

        $message = $content;

        /* Subject */
        $subject = $email_details->email_subject;

        /* To */
        $to = $this->input->post('user_email');

        /* Sender Copy */
        $sender_copy = $this->input->post('sender-copy');

        if ($sender_copy) {
            $bcc = $email;
        } else {
            $bcc = false;
        }

        /* Send Email */
        $this->main_model->email($to, $subject, $message, $bcc, $email, $name);

        /* Return */
        $this->session->set_flashdata("return", "send_message_success");

        /* Redirect */
        redirect("anuncio/" . $ad->ad_slug);
    }

    public function add_favorite($code) {
        /* Verify Session */
        if ($this->session->userdata('login')) {

            /* Add Favorite */
            $this->user_model->favoritesInsert($code);

            /* Return */
            $this->session->set_flashdata("return", "ads_add_favorite");

            /* Redirect */
            redirect("ads/details/" . $code);
        } else {
            /* Return */
            $this->session->set_flashdata("return", "login_required");

            /* Redirect */
            redirect("ads/details/" . $code);
        }
    }

    public function remove_favorite($code) {
        /* Remove Favorite */
        $this->user_model->favoritesDelete($code);

        /* Return */
        $this->session->set_flashdata("return", "ads_remove_favorite");

        /* Redirect */
        redirect("ads/details/" . $code);
    }

    public function report($code, $view = "modal") {
        if ($view == "modal") {
            $data['code'] = $code;
            $data['modal_title'] = "Denunciar esse anúncio";
            $data['modal_size'] = "medium";

            $this->template->load('modal', 'ads_report', $data);
        } elseif ($view == "send") {
            /* POST */
            $name = validate_name($this->input->post('name'));
            $reason = $this->input->post('reason');
            $text = $this->input->post('text');

            /* ad details */
            $ad = $this->ads_model->details($code);
            $ad_name = $ad->ad_name;
            $ad_link = base_url('anuncio/' . $ad->ad_slug);

            /* Email Details */
            $email_details = $this->main_model->emailsDetails(4);

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

            $message = $content;

            /* Subject */
            $subject = $email_details->email_subject;

            /* to */
            $to = $this->main_model->config('cfg_contact_email');

            /* send email */
            $this->main_model->email($to, $subject, $message);

            /* return */
            $this->session->set_flashdata("return", "ads_report_success");

            /* redirect */
            redirect("ads/details/" . $code);
        }
    }

    public function email_share($code, $view = "modal") {
        if ($view == "modal") {
            $data['code'] = $code;
            $data['modal_title'] = "Compartilhar via e-mail";
            $data['modal_size'] = "medium";

            $this->template->load('modal', 'ads_email_share', $data);
        } elseif ($view == "send") {
            /* POST */
            $name = validate_name($this->input->post('name'));
            $email = $this->input->post('email');
            $text = $this->input->post('text');

            /* ad details */
            $ad = $this->ads_model->details($code);
            $ad_name = $ad->ad_name;
            $ad_link = base_url('anuncio/' . $ad->ad_slug);

            /* Email Details */
            $email_details = $this->main_model->emailsDetails(5);

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

            $message = $content;

            /* Subject */
            $subject = $email_details->email_subject;

            /* to */
            $to = $email;

            /* send email */
            $this->main_model->email($to, $subject, $message, false);

            /* return */
            $this->session->set_flashdata("return", "ads_email_share_send");

            /* redirect */
            redirect($ad_link);
        }
    }

}

/* End of file Ads.php */
/* Location: ./application/controllers/Ads.php */