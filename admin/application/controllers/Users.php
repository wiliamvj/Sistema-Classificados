<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $data['listing'] = $this->panamerico_model->listing('users', 'use_id', 'DESC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'use_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('users', array(
            'use_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->template->load('system', 'users', $data);
    }
    
      public function ajax() {

        $data['listing'] = $this->panamerico_model->listing('users', 'use_name', 'ASC', paginacao()->getQtd(), paginacao()->getInicio(), array(
            'use_name' => $this->input->get('search'),
        ));

        $total_rows = $this->panamerico_model->contall('users', array(
            'use_name' => $this->input->get('search'),
        ));
        $data['total'] = $total_rows;
        $this->load->view('system/users', $data);
    }

    public function details($code) {
        $data['item'] = $this->panamerico_model->details('users', 'use_id', $code);

        $data['ads'] = $this->panamerico_model->listingByWhere('ads', 'use_id', $code);

        $this->template->load('system', 'users_details', $data);
    }

    public function insert() {
        $data['e'] = false;

        $data['states'] = $this->panamerico_model->listing('states', 'sta_name', 'ASC');

        $this->template->load('system', 'users_form', $data);
    }

    public function edit($code) {
        $data['e'] = true;

        $data['item'] = $this->panamerico_model->details('users', 'use_id', $code);

        $regions = $this->main_model->regionsDetails($data['item']->use_region);
        $regions = @$regions->regiao_nome;
        $data['region'] = $regions;

        $data['states'] = $this->panamerico_model->listing('states', 'sta_name', 'ASC');

        $this->template->load('system', 'users_form', $data);
    }

    public function save() {
        $e = $this->input->post("e");

        $name = $this->input->post("name");
        $status = $this->input->post("status");
        $email = $this->input->post("email");
        $cpf = $this->input->post("cpf");
        $phone = $this->input->post("phone");
        $celular = $this->input->post("celular");
        $whatsapp = $this->input->post("whatsapp");
        $website = $this->input->post("website");
        $facebook = $this->input->post("facebook");
        $instagram = $this->input->post("instagram");
        $elo7 = $this->input->post("elo7");
        $mercado_livre = $this->input->post("mercado_livre");
        $cep = $this->input->post("cep");
        $address = $this->input->post("address");
        $region = $this->input->post("region");
        $city = $this->input->post("city");
        $state = $this->input->post("state");
        $neighborhood = $this->input->post("neighborhood");

        $data = array(
            'use_name' => $name,
            'use_status' => $status,
            'use_email' => $email,
            'use_cpf' => $cpf,
            'use_phone' => $phone,
            'use_celular' => $celular,
            'use_whatsapp' => $whatsapp,
            'use_website' => $website,
            'use_facebook' => $facebook,
            'use_instagram' => $instagram,
            'use_elo7' => $elo7,
            'use_mercado_livre' => $mercado_livre,
            'use_cep' => $cep,
            'use_address' => $address,
            'use_region' => $region,
            'use_city' => $city,
            'use_state' => $state,
            'use_neighborhood' => $neighborhood
        );

        if ($e) {
            $this->panamerico_model->update('users', 'use_id', $e, $data);
        } else {
            $e = $this->panamerico_model->insert('users', $data);
        }

        $this->session->set_flashdata('return', 'save');

        redirect("users");
    }

    public function delete($view = "modal", $code) {
        if ($view == "modal") {
            $data['modal_title'] = "Apagar Usuário";
            $data['modal_text'] = "Você tem certeza que deseja apagar esse usuário?";
            $data['modal_link_href'] = base_url('users/delete/action/' . $code);
            $data['modal_link_type'] = 'danger';
            $data['modal_link_text'] = 'Apagar';

            $this->template->load('modal', 'default', $data);
        }

        if ($view == "action") {
            $this->panamerico_model->delete('users', 'use_id', $code);

            $this->session->set_flashdata('return', 'delete');

            redirect('users');
        }
    }

    public function cities($state) {
        $cities = $this->panamerico_model->listingByWhere('cities', 'sta_id', $state);

        foreach ($cities as $key => $city) {
            echo '<option value="' . $city->cit_id . '">' . $city->cit_name . '</option>';
        }
    }

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */