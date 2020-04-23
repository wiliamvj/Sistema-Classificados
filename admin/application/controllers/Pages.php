<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $data['listing'] = $this->panamerico_model->listing('pages', 'page_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'page_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('pages', array(
            'page_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->template->load('system', 'pages', $data);
    }
    
     public function ajax() {

        $data['listing'] = $this->panamerico_model->listing('pages', 'page_name', 'ASC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'page_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('pages', array(
            'page_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->load->view('system/pages', $data);
    }

    public function insert() {
        $data['e'] = false;

        $this->template->load('system', 'pages_form', $data);
    }

    public function edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('pages', 'page_id', $code);

        $data['faq'] = $this->panamerico_model->listingByWhere('pages_faq', 'page_id', $code);

        $this->template->load('system', 'pages_form', $data);
    }

    public function save() {
        $e = $this->input->post("e");

        $name = $this->input->post("name");
        $slug = $this->input->post("slug");
        $icon = $this->input->post("icon");
        $content = $this->input->post("content");
        $status = $this->input->post("status");

        $data = array(
            'page_name' => $name,
            'page_slug' => strtolower(url_title($slug)),
            'page_icon' => $icon,
            'page_content' => $content,
            'page_status' => $status
        );

        if ($e) {
            $this->panamerico_model->update('pages', 'page_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('pages', $data);
        }

        $faq_questions = $this->input->post("faq_q[]");
        $faq_answers = $this->input->post("faq_a[]");

        $this->panamerico_model->delete('pages_faq', 'page_id', $e);

        if ($faq_questions) {
            foreach ($faq_questions as $key => $faq_q) {
                $answer = $faq_answers[$key];

                $faq = array(
                    'page_id' => $e,
                    'page_faq_question' => $faq_q,
                    'page_faq_answer' => $answer
                );

                $this->panamerico_model->insert('pages_faq', $faq);
            }
        }

        $this->session->set_flashdata('return', 'save');

        redirect("pages");
    }

    public function delete($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Página";
            $data['modal_text'] = "Você tem certeza que deseja apagar essa página?";
            $data['modal_link_href'] = base_url('pages/delete/action/' . $code);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $this->panamerico_model->delete('pages', 'page_id', $code);

            $this->session->set_flashdata('return', 'delete');

            redirect('pages');
        }
    }

}

/* End of file Pages.php */
/* Location: ./application/controllers/Pages.php */