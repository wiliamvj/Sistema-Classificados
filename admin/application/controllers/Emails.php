<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Emails extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
       
        $data['listing'] = $this->panamerico_model->listing('emails', 'email_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'email_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('emails', array(
            'email_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->template->load('system', 'emails', $data);
    }
     public function ajax() {
       
        $data['listing'] = $this->panamerico_model->listing('emails', 'email_name', 'ASC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'email_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('emails', array(
            'email_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->load->view('system/emails', $data);
    }

    public function edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('emails', 'email_id', $code);

        $data['tags'] = $this->panamerico_model->listingByWhere('emails_tags', 'email_id', $code);

        $this->template->load('system', 'emails_form', $data);
    }

    public function save() {
        $e = $this->input->post("e");

        $subject = $this->input->post("subject");
        $content = $this->input->post("content");

        $data = array(
            'email_subject' => $subject,
            'email_content' => $content,
        );

        if ($e) {
            $this->panamerico_model->update('emails', 'email_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('emails', $data);
        }

        $this->session->set_flashdata('return', 'save');

        redirect("emails");
    }

}

/* End of file Emails.php */
/* Location: ./application/controllers/Emails.php */