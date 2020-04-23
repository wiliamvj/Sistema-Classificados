<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class App extends MY_Controller {

    public function __construct() {
        parent::__construct();
       
    }

    public function index() {
       $data['listing'] = $this->panamerico_model->listing('ads', 'ad_id', 'ASC', paginacao()->getQtd(), paginacao()->getInicio() , array(
            'ad_name' => $this->input->get('search'),
            'ad_id' => $this->input->get('search'),
        ));
        
        $total_rows = $this->panamerico_model->contall('ads', array(
            'ad_name' => $this->input->get('search'),
            'ad_id' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->template->load('system', 'app', $data);
    }

     public function ajax() {
        $data['listing'] = $this->panamerico_model->listing('ads', 'ad_id', 'ASC', paginacao()->getQtd(), paginacao()->getInicio() , array(
            'ad_name' => $this->input->get('search'),
            'ad_id' => $this->input->get('search'),
        ));
        
        $total_rows = $this->panamerico_model->contall('ads', array(
            'ad_name' => $this->input->get('search'),
            'ad_id' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->load->view('system/app', $data);
    }

}

/* End of file App.php */
/* Location: ./application/controllers/App.php */