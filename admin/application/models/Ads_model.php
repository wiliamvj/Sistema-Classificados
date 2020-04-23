<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ads_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function insert($data) {
        $this->db->insert("ads", $data);

        return $this->db->insert_id();
    }

    public function update($data, $code) {
        $this->db->where("ad_id", $code);
        $this->db->update("ads", $data);
    }


    public function cleanCustomFields($code) {
        $this->db->where("ad_id", $code);
        $this->db->delete("ads_custom");
    }

    public function cleanCustomCheckbox($code) {
        $this->db->where("ad_id", $code);
        $this->db->delete("ads_custom_checkboxs");
    }

    public function insertCustomField($data) {
        $this->db->insert("ads_custom", $data);
    }

    public function insertCustomCheckbox($data) {
        $this->db->insert("ads_custom_checkboxs", $data);
    }

    public function customFields($code) {
        $this->db->order_by('ads_custom.ads_cus_id', 'ASC');
        $this->db->where('ads_custom.ad_id', $code);
        $this->db->where('categories_fields.cat_fie_status', 1);

        $this->db->join('categories_fields', 'categories_fields.cat_fie_id = ads_custom.cat_fie_id', 'LEFT');

        $query = $this->db->get("ads_custom");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function customSelectOption($code) {
        $this->db->where('sel_opt_id', $code);
        $query = $this->db->get("fields_select_options");
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            return false;
        }
    }

    public function customCheckboxOption($code, $checkbox) {
        $this->db->where('ads_custom_checkboxs.ad_id', $code);
        $this->db->where('ads_custom_checkboxs.cat_fie_id', $checkbox);

        $this->db->join('fields_checkbox_options', 'fields_checkbox_options.che_opt_id = ads_custom_checkboxs.che_opt_id', 'LEFT');

        $query = $this->db->get("ads_custom_checkboxs");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function customFieldValue($ads_code, $field_code) {
        $this->db->where('ad_id', $ads_code);
        $this->db->where('cat_fie_id', $field_code);
        $query = $this->db->get("ads_custom");
        $query = $query->result();

        if ($query) {
            return $query[0]->ads_cus_value;
        } else {
            return false;
        }
    }

    public function checkCustomCheckbox($ad_code, $opt_code) {
        $this->db->where('ad_id', $ad_code);
        $this->db->where('che_opt_id', $opt_code);
        $query = $this->db->get("ads_custom_checkboxs");
        $query = $query->result();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }


}

/* End of file ads_model.php */
/* Location: ./application/models/ads_model.php */
