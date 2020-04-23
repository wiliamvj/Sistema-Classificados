<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonials extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['listing'] = $this->panamerico_model->listing('testimonials', 'tes_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'tes_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('testimonials', array(
            'tes_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->template->load('system', 'testimonials', $data);
    }
    
     public function ajax() {
        $data['listing'] = $this->panamerico_model->listing('testimonials', 'tes_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'tes_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('testimonials', array(
            'tes_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->load->view('system/testimonials', $data);
    }

    public function edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('testimonials', 'tes_id', $code);

        $this->template->load('system', 'testimonials_form', $data);
    }

    public function save() {
        $e = $this->input->post("e");

        $name = $this->input->post("name");
        $status = $this->input->post("status");
        $ad = $this->input->post("ad");
        $category = $this->input->post("category");
        $text = $this->input->post("text");

        $data = array(
            'tes_name' => $name,
            'tes_status' => $status,
            'tes_ad' => $ad,
            'tes_category' => $category,
            'tes_text' => $text
        );

        if ($e) {
            $this->panamerico_model->update('testimonials', 'tes_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('testimonials', $data);
        }

        $this->session->set_flashdata('return', 'save');

        redirect("testimonials");
    }

    public function delete($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Depoimento";
            $data['modal_text'] = "Você tem certeza que deseja apagar esse depoimento?";
            $data['modal_link_href'] = base_url('testimonials/delete/action/' . $code);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $this->panamerico_model->delete('testimonials', 'tes_id', $code);

            $this->session->set_flashdata('return', 'delete');

            redirect('testimonials');
        }
    }

    public function approve($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Aprovar Depoimento";
            $data['modal_text'] = "Você tem certeza que deseja aprovar esse depoimento?";
            $data['modal_link_href'] = base_url('testimonials/approve/action/' . $code);
            $data['modal_link_type'] = 'success';
            $data['modal_link_text'] = 'Aprovar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $data = array('tes_status' => 1);

            $this->panamerico_model->update('testimonials', 'tes_id', $code, $data);

            $this->session->set_flashdata('return', 'save');

            redirect('testimonials');
        }
    }

}

/* End of file Testimonials.php */
/* Location: ./application/controllers/Testimonials.php */