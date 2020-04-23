<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function info($column = false) {

        $this->db->limit(1);
        $this->db->where('use_id', $this->session->userdata('login'));

        if ($column) {
            $this->db->select($column);
        }

        $query = $this->db->get('users');
        $query = $query->result();

        if ($query) {
            if ($column) {
                return $query[0]->$column;
            } else {
                return $query[0];
            }
        } else {
            redirect('login/out');
        }
    }

    public function update($data, $code = false) {
        if ($code) {
            $this->db->where('use_id', $code);
        } else {
            $this->db->where('use_id', $this->session->userdata('login'));
        }

        $this->db->update('users', $data);
    }

    public function passRecover($token, $password) {
        $this->db->where('use_token', $token);
        $this->db->set('use_password', $password);
        $this->db->set('use_token', '');
        $this->db->update('users');
    }

    public function insert($data) {
        $this->db->insert('users', $data);

        return $this->db->insert_id();
    }

    public function getByEmail($email) {
        $this->db->limit(1);
        $this->db->where('use_email', $email);
        $this->db->select('use_id');
        $query = $this->db->get('users');
        $query = $query->result();

        if ($query) {
            return $query[0]->use_id;
        } else {
            return false;
        }
    }

    public function emailVerify($email) {
        $this->db->limit(1);
        $this->db->where('use_email', $email);
        $query = $this->db->get('users');
        $query = $query->result();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function tokenVerify($token) {
        $this->db->limit(1);
        $this->db->where('use_token', $token);
        $query = $this->db->get('users');
        $query = $query->result();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function login($email, $password) {
        $this->db->limit(1);
        $this->db->where('use_email', $email);
        $this->db->where('use_password', $password);
        $this->db->select("use_id");
        $query = $this->db->get('users');
        $query = $query->result();

        if ($query) {
            return $query[0]->use_id;
        } else {
            return false;
        }
    }

    public function favorites() {
        $this->db->order_by('users_favorites.use_fav_id', 'DESC');

        $this->db->where('users_favorites.use_id', $this->session->userdata('login'));
        $this->db->where('ads.ad_status', 2);

        $this->db->join("ads", "users_favorites.ad_id = ads.ad_id", "LEFT");
        $this->db->join("ads_categories", "ads.ads_cat_id = ads_categories.ads_cat_id", "LEFT");
        $this->db->join("users", "ads.use_id = users.use_id", "LEFT");

        $query = $this->db->get("users_favorites");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function favoriteVerify($code) {
        $this->db->limit(1);
        $this->db->where("use_id", $this->session->userdata('login'));
        $this->db->where("ad_id", $code);
        $query = $this->db->get("users_favorites");
        $query = $query->result();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function favoritesInsert($code) {
        $this->db->set("use_id", $this->session->userdata('login'));
        $this->db->set("ad_id", $code);
        $this->db->insert("users_favorites");
    }

    public function favoritesDelete($code) {
        $this->db->where("use_id", $this->session->userdata('login'));
        $this->db->where("ad_id", $code);
        $this->db->delete("users_favorites");
    }
     public function countAds($status) {
       
        if ($status) {
            $this->db->where('ads.ad_status', $status);
        }
        $this->db->where('ads.ad_status != ', 5);
        $this->db->where('ads.use_id', $this->session->userdata('login'));
        $this->db->join("ads_categories", "ads.ads_cat_id = ads_categories.ads_cat_id", "LEFT");
        $this->db->join("users", "ads.use_id = users.use_id", "LEFT");
        $query = $this->db->get("ads");
        return $query->num_rows();

    }

    public function ads($status, $limit = false, $offset = null) {
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('ads.ad_id', 'DESC');
        if ($status) {
            $this->db->where('ads.ad_status', $status);
        }
        $this->db->where('ads.ad_status != ', 5);

        $this->db->where('ads.use_id', $this->session->userdata('login'));
        $this->db->join("ads_categories", "ads.ads_cat_id = ads_categories.ads_cat_id", "LEFT");
        $this->db->join("users", "ads.use_id = users.use_id", "LEFT");

        $query = $this->db->get("ads");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function adsCount($status) {
        $this->db->where('use_id', $this->session->userdata('login'));
        $this->db->where('ad_status', $status);
        $count = $this->db->count_all_results("ads");

        return $count;
    }

}

/* End of file User_model.php */
/* Location: ./application/models/User_model.php */