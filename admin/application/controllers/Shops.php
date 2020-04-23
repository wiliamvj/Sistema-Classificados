<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Shops extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['listing'] = $this->panamerico_model->listing('shops', 'shop_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'shop_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('shops', array(
            'shop_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->template->load('system', 'shops', $data);
    }

    public function ajax() {
       
        $data['listing'] = $this->panamerico_model->listing('shops', 'shop_name', 'ASC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'shop_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('shops', array(
            'shop_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->load->view('system/shops', $data);
    }

    public function edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('shops', 'shop_id', $code);

        if ($data['item']->shop_use_info) {

            $regions = $this->main_model->regionsDetails($data['item']->shop_region);
            $regions = @$regions->regiao_nome;
            $data['region'] = $regions;
        } else {

            $regions = $this->main_model->regionsDetails($data['item']->shop_region);
            $regions = @$regions->regiao_nome;
            $data['region'] = $regions;
        }

        $data['categories'] = $this->panamerico_model->listingByWhere('ads_categories', 'ads_cat_parent', 0);

        $data['states'] = $this->panamerico_model->listing('states', 'sta_name', 'ASC');

        $this->template->load('system', 'shops_form', $data);
    }

    public function save() {
        $e = $this->input->post("e");

        $name = $this->input->post("name");
        $status = $this->input->post("status");
        $desc = $this->input->post("desc");
        $category = $this->input->post("category");
        $phone = $this->input->post("phone");
        $slug = $this->input->post("slug");
        $image = $this->input->post("image");
        $user_info = $this->input->post("user_info");
        $address = $this->input->post("address");
        $address_add = $this->input->post("address_add");
        $city = $this->input->post("city");
        $state = $this->input->post("state");
        $region = $this->input->post("region");
        $neighborhood = $this->input->post("neighborhood");

        $data = array(
            'shop_name' => $name,
            'shop_status' => $status,
            'shop_desc' => $desc,
            'ads_cat_id' => $category,
            'shop_phone' => $phone,
            'shop_slug' => $slug,
            'shop_user_info' => (($user_info) ? 1 : 0),
            'shop_address' => $address,
            'shop_address_add' => $address_add,
            'shop_city' => $city,
            'shop_state' => $state,
            'shop_region' => $region,
            'shop_neighborhood' => $neighborhood,
        );

        if ($e) {
            $this->panamerico_model->update('shops', 'shop_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('shops', $data);
        }

        if (file_exists($_FILES['image']['tmp_name']) || is_uploaded_file($_FILES['image']['tmp_name'])) {
            $upload_img = @$this->panamerico_model->uploadImage("image", "shops");

            if ($upload_img['file_name']) {
                $img_data = array(
                    "shop_img_path" => $upload_img['full_path'],
                    "shop_img_file" => $upload_img['file_name']
                );

                $this->panamerico_model->update('shops', 'shop_id', $e, $img_data);
            }
        }

        $this->session->set_flashdata('return', 'save');

        redirect("shops");
    }

    public function delete($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Loja";
            $data['modal_text'] = "Você tem certeza que deseja apagar essa loja?";
            $data['modal_link_href'] = base_url('shops/delete/action/' . $code);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $this->panamerico_model->delete('shops', 'shop_id', $code);

            $this->session->set_flashdata('return', 'delete');

            redirect('shops');
        }
    }

    public function cities($state) {
        $cities = $this->panamerico_model->listingByWhere('cities', 'sta_id', $state);

        foreach ($cities as $key => $city) {
            echo '<option value="' . $city->cit_id . '">' . $city->cit_name . '</option>';
        }
    }

}

/* End of file Shops.php */
/* Location: ./application/controllers/Shops.php */