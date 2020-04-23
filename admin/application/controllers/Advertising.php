<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advertising extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['listing'] = $this->panamerico_model->listing('advertising', 'adv_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'adv_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('advertising', array(
            'adv_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->template->load('system', 'advertising', $data);
    }
      public function ajax() {
        $data['listing'] = $this->panamerico_model->listing('advertising', 'adv_id', 'ASC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'adv_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('advertising', array(
            'adv_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->load->view('system/advertising', $data);
    }

    public function insert() {
        $data['e'] = false;

        $this->template->load('system', 'advertising_form', $data);
    }

    public function edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('advertising', 'adv_id', $code);

        $this->template->load('system', 'advertising_form', $data);
    }

    public function save() {
        $e = $this->input->post("e");

        $name = $this->input->post("name");
        $position = $this->input->post("position");
        $content = $this->input->post("content");
        $status = $this->input->post("status");

        $data = array(
            'adv_name' => $name,
            'adv_position' => $position,
            'adv_content' => $content,
            'adv_status' => $status
        );

        if ($e) {
            $this->panamerico_model->update('advertising', 'adv_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('advertising', $data);
        }

        $this->session->set_flashdata('return', 'save');

        redirect("advertising");
    }

    public function delete($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Publicidade";
            $data['modal_text'] = "Você tem certeza que deseja apagar esse bloco de publicidade?";
            $data['modal_link_href'] = base_url('advertising/delete/action/' . $code);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $this->panamerico_model->delete('advertising', 'adv_id', $code);

            $this->session->set_flashdata('return', 'delete');

            redirect('advertising');
        }
    }

}

/* End of file Advertising.php */
/* Location: ./application/controllers/Advertising.php */