<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        
        $data['listing'] = $this->panamerico_model->listing('ads_categories', 'ads_cat_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'ads_cat_name' => $this->input->get('search'),
                ), array(
            'ads_cat_parent' => '0'
        ));

        $total_rows = $this->panamerico_model->contall('ads_categories', array(
            'ads_cat_name' => $this->input->get('search'),
        ), array(
            'ads_cat_parent' => '0'
        ));
        $data['total'] = $total_rows;
        $this->template->load('system', 'categories', $data);
    }
    
     public function ajax() {
        
        $data['listing'] = $this->panamerico_model->listing('ads_categories', 'ads_cat_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'ads_cat_name' => $this->input->get('search'),
                ), array(
            'ads_cat_parent' => 0
        ));

        $total_rows = $this->panamerico_model->contall('ads_categories', array(
            'ads_cat_name' => $this->input->get('search'),
        ), array(
            'ads_cat_parent' => 0
        ));
        $data['total'] = $total_rows;
        $this->load->view('system/categories', $data);
    }

    public function insert() {
        $data['e'] = false;

        $this->template->load('system', 'categories_form', $data);
    }

    public function edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $code);

        $this->template->load('system', 'categories_form', $data);
    }

    public function save() {
        $e = $this->input->post("e");

        $name = $this->input->post("name");
        $icon = $this->input->post("icon");
        $status = $this->input->post("status");

        $data = array(
            'ads_cat_name' => $name,
            'ads_cat_icon' => $icon,
            'ads_cat_parent' => 0,
            'ads_cat_status' => $status
        );

        if ($e) {
            $this->panamerico_model->update('ads_categories', 'ads_cat_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('ads_categories', $data);
        }

        $this->session->set_flashdata('return', 'save');

        redirect("categories");
    }

    public function delete($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Categoria";
            $data['modal_text'] = "Você tem certeza que deseja apagar essa categoria?";
            $data['modal_link_href'] = base_url('categories/delete/action/' . $code);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $this->panamerico_model->delete('ads_categories', 'ads_cat_id', $code);

            $this->session->set_flashdata('return', 'delete');

            redirect('categories');
        }
    }

    public function secondary($code) {
        $data['code'] = $code;

        $data['primary'] = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $code);

        $data['listing'] = $this->panamerico_model->listingByWhere('ads_categories', 'ads_cat_parent', $code);

        $this->template->load('system', 'categories_secondary', $data);
    }

    public function secondary_insert($code) {
        $data['e'] = false;

        $data['code'] = $code;

        $this->template->load('system', 'categories_secondary_form', $data);
    }

    public function secondary_edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $code);

        $this->template->load('system', 'categories_secondary_form', $data);
    }

    public function secondary_save() {
        $e = $this->input->post("e");

        $name = $this->input->post("name");
        $parent = $this->input->post("parent");
        $status = $this->input->post("status");

        $data = array(
            'ads_cat_name' => $name,
            'ads_cat_parent' => $parent,
            'ads_cat_status' => $status
        );

        if ($e) {
            $this->panamerico_model->update('ads_categories', 'ads_cat_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('ads_categories', $data);
        }

        $this->session->set_flashdata('return', 'save');

        redirect("categories/secondary/" . $parent);
    }

    public function secondary_delete($view = "modal", $code, $parent) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Categoria";
            $data['modal_text'] = "Você tem certeza que deseja apagar essa categoria?";
            $data['modal_link_href'] = base_url('categories/secondary_delete/action/' . $code . '/' . $parent);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $this->panamerico_model->delete('ads_categories', 'ads_cat_id', $code);

            $this->session->set_flashdata('return', 'delete');

            redirect('categories/secondary/' . $parent);
        }
    }

    public function fields($code) {
        $data['category'] = $this->panamerico_model->details('ads_categories', 'ads_cat_id', $code);

        $data['listing'] = $this->panamerico_model->listingByWhere('categories_fields', 'ads_cat_id', $code);

        $this->template->load('system', 'categories_fields', $data);
    }

    public function fields_insert($code) {
        $data['e'] = false;

        $data['code'] = $code;

        $this->template->load('system', 'categories_fields_form', $data);
    }

    public function fields_edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('categories_fields', 'cat_fie_id', $code);

        if ($data['item']->cat_fie_type == "select") {
            $data['options'] = $this->panamerico_model->listingByWhere('fields_select_options', 'cat_fie_id', $code);
        }

        $this->template->load('system', 'categories_fields_form', $data);
    }

    public function fields_save() {
        $e = $this->input->post("e");

        $name = $this->input->post("name");
        $category = $this->input->post("category");
        $type = $this->input->post("type");
        $required = $this->input->post("required");
        $status = $this->input->post("status");

        $data = array(
            'cat_fie_name' => $name,
            'ads_cat_id' => $category,
            'cat_fie_type' => $type,
            'cat_fie_required' => $required,
            'cat_fie_status' => $status,
        );

        if ($type == "text") {
            $data['cat_fie_placeholder'] = $this->input->post("text_placeholder");
            $data['cat_fie_text_mask'] = $this->input->post("text_mask");
        }

        if ($type == "textarea") {
            $data['cat_fie_placeholder'] = $this->input->post("textarea_placeholder");
            $data['cat_fie_textarea_rows'] = $this->input->post("textarea_rows");
        }

        if ($type == "select") {
            $data['cat_fie_select_options'] = $this->input->post("select_options");
            $data['cat_fie_select_default'] = $this->input->post("select_default");
        }

        if ($type == "checkbox") {
            $data['cat_fie_checkbox_options'] = $this->input->post("checkbox_options");
        }

        if ($e) {
            $this->panamerico_model->update('categories_fields', 'cat_fie_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('categories_fields', $data);
        }

        if ($type == "select") {
            $options = $this->input->post('select_options');
            $options = explode(PHP_EOL, $options);

            $this->panamerico_model->delete('fields_select_options', 'cat_fie_id', $e);

            foreach ($options as $key => $value) {
                $data = array('cat_fie_id' => $e, 'sel_opt_name' => $value);

                $this->panamerico_model->insert('fields_select_options', $data);
            }
        }

        if ($type == "checkbox") {
            $options = $this->input->post('checkbox_options');
            $options = explode(PHP_EOL, $options);

            $this->panamerico_model->delete('fields_checkbox_options', 'cat_fie_id', $e);

            foreach ($options as $key => $value) {
                $data = array('cat_fie_id' => $e, 'che_opt_name' => $value);

                $this->panamerico_model->insert('fields_checkbox_options', $data);
            }
        }

        $this->session->set_flashdata('return', 'save');

        redirect("categories/fields/" . $category);
    }

    public function fields_delete($view = "modal", $code, $category) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Campo";
            $data['modal_text'] = "Você tem certeza que deseja apagar esse campo?";
            $data['modal_link_href'] = base_url('categories/fields_delete/action/' . $code . '/' . $category);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $this->panamerico_model->delete('categories_fields', 'cat_fie_id', $code);

            $this->session->set_flashdata('return', 'delete');

            redirect('categories/fields/' . $category);
        }
    }

}

/* End of file Categories.php */
/* Location: ./application/controllers/Categories.php */