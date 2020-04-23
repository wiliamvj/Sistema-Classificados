<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shops extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index($filter = false, $param_1 = false) {
        paginacao()->config(20);
        $data['shops'] = $this->shops_model->listing('shops.shop_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'shops.shop_name' => $this->input->get('string'),
            'shops.shop_id' => $this->input->get('string'),
                ), array(
            'shops.ads_cat_id' => ($filter == 'category') ? $param_1 : (int) $this->input->get('category'),
            'shops.shop_state' => (int) $this->input->get('state')
        ));

        $total_rows = $this->shops_model->contallShops(array(
            'shops.shop_name' => $this->input->get('string'),
            'shops.shop_id' => (int) $this->input->get('string'),
                ), array(
            'shops.ads_cat_id' => ($filter == 'category') ? $param_1 : (int) $this->input->get('category'),
            'shops.shop_state' => (int) $this->input->get('state')
        ));
        //calcular paginacao
        $data['total'] = $total_rows;

        $data['states'] = $this->main_model->states();
        /* Categories */
        $data['categories'] = $this->ads_model->categories(0);
        /* Breadcrumbs */
        $data['breadcrumbs'][] = array('name' => 'Vendedores');
        /* SEO */
        $data['seo_title'] = "Lojas";
        /* View */
        $this->template->load('app', 'shops', $data);
    }

    public function details($code) { /* Shop Details */
        $data['shop'] = $this->shops_model->details($code);  /* Breadcrumbs */ $data['breadcrumbs'][] = array('name' => 'Vendedores', 'link' => base_url('vendedores'));
        $data['breadcrumbs'][] = array('name' => $data['shop']->shop_name);  /* SEO */ $data['seo_title'] = $data['shop']->shop_name . " - Lojas";  /* View */ $this->template->load('app', 'shops_details', $data);
    }

    public function route($slug) {
        $shop = $this->shops_model->getBySlug($slug);
        $this->details($shop->shop_id);
    }

    public function category($code) {
        $this->index('category', $code);
    }

    public function email_share($code, $view = "modal") {
        if ($view == "modal") {
            $data['code'] = $code;
            $data['modal_title'] = "Compartilhar via e-mail";
            $data['modal_size'] = "medium";
            $this->template->load('modal', 'shops_email_share', $data);
        } elseif ($view == "send") { /* POST */
            $name = validate_name($this->input->post('name'));
            $email = $this->input->post('email');
            $text = $this->input->post('text');   /* ad details */ $shop = $this->shops_model->details($code);
            $shop_name = $shop->shop_name;
            $shop_link = base_url('loja/' . $shop->shop_slug);   /* Email Details */ $email_details = $this->main_model->emailsDetails(6);   /* Message */ $content = $email_details->email_content;
            if (preg_match_all('/({\$+\w+})/', $content, $matches)) {
                foreach ($matches[0] as $key => $value) {
                    $variable = str_replace('{', '', $value);
                    $variable = str_replace('}', '', $variable);
                    $string = eval('return ' . $variable . ';');
                    $content = str_replace($value, $string, $content);
                }
            } $message = $content;   /* Subject */ $subject = $email_details->email_subject;   /* to */ $to = $email;   /* send email */ $this->main_model->email($to, $subject, $message, false);   /* return */ $this->session->set_flashdata("return", "shops_email_share_send");   /* redirect */ redirect($shop_link);
        }
    }

    public function slug_verify() {
        $code = $this->input->post('code');
        $string = $this->input->post('string');
        $verify = $this->shops_model->slugVerify($string, $code);
        if ($verify) {
            echo 'slug_yes';
        } else {
            echo 'slug_no';
        }
    }

}

/* End of file Shops.php *//* Location: ./application/controllers/Shops.php */