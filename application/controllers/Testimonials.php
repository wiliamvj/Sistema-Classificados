<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Testimonials extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        paginacao()->config(9); /* Testimonals */
        $data['testimonials'] = $this->main_model->testimonials(paginacao()->getQtd(), paginacao()->getInicio());
        //total depoimentos
        $data['total'] = $this->main_model->countTestimonials();
        /* Breadcrumbs */
        $data['breadcrumbs'][] = array('name' => 'Depoimentos');

        /* SEO */
        $data['seo_title'] = "Depoimentos";

        /* View */
        $this->template->load('app', 'testimonials', $data);
    }

}

/* End of file Testimonials.php */
/* Location: ./application/controllers/Testimonials.php */