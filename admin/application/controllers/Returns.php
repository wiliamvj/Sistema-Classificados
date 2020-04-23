<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Returns extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['listing'] = $this->panamerico_model->listing('returns', 'ret_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'ret_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('returns', array(
            'ret_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->template->load('system', 'returns', $data);
    }
     public function ajax() {
        $data['listing'] = $this->panamerico_model->listing('returns', 'ret_name', 'ASC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'ret_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('returns', array(
            'ret_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->load->view('system/returns', $data);
    }

    public function edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('returns', 'ret_id', $code);

        $this->template->load('system', 'returns_form', $data);
    }

    public function save() {
        $e = $this->input->post("e");

        $type = $this->input->post("type");
        $icon = $this->input->post("icon");
        $text = $this->input->post("text");

        $data = array(
            'ret_type' => $type,
            'ret_icon' => $icon,
            'ret_text' => $text
        );

        if ($e) {
            $this->panamerico_model->update('returns', 'ret_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('returns', $data);
        }

        $this->session->set_flashdata('return', 'save');

        redirect("returns");
    }

}

/* End of file Returns.php */
/* Location: ./application/controllers/Returns.php */