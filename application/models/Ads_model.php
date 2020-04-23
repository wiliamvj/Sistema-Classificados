<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ads_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listaFiltro($tabela, $nomeOrder, $order, array $select = array(), array $where = array(), array $busca = array()) {

        // $this->db->order_by($nomeOrder, $order);
        $this->get_where($where);
        $this->get_search($busca);
        $this->get_seletc($select);
        $q = $this->db->get($tabela);
        //echo $this->db->last_query();
        return $q->result();
    }

    public function mostraCountAds() {
        $this->db->select('cfg_ads_count');
        $q = $this->db->get('config');
        $query = $q->result();
        return $query[0]->cfg_ads_count;
    }

    public function totalAnuncio(array $where = array(), $ops = FALSE) {

        $this->db->select('ad_id');
        $this->get_where($where);
        $q = $this->db->get('ads');
        if ($ops === FALSE and $this->mostraCountAds() == 1) {
            return ($q->num_rows() > 0) ? ', ' . number_format($q->num_rows(), 0, '.', '.') : NULL;
        } else if ($ops === TRUE) {
            return $q->num_rows();
        }
    }

    function get_seletc(array $busca = array()) {
        if (count($busca)) {
            $busc = array_filter($busca);
            foreach ($busc as $value) {
                $v .= $value . ', ';
            }
            $result = substr($v, 0, -2);
            return $this->db->select($result);
        }
    }

    function get_search(array $busca = array()) {
        if (count($busca)) {
            $busca = array_filter($busca);
            foreach ($busca as $key => $value) {
                $q .= $this->db->like($key, $value);
            }
        }

        return $q;
    }

    function get_where(array $where = array()) {
        if (count($where)) {
            $where = array_filter($where);
            foreach ($where as $key => $value) {
                $q .= $this->db->where($key, $value);
            }
        }

        return $q;
    }

    public function limite($limit = FALSE, $offset = null) {
        if ($limit) {
            return $this->db->limit($limit, $offset);
        }
    }

    public function orderBy($order_by = false, $order_how = FALSE) {
        if ($order_by && $order_how) {
            return $this->db->order_by($order_by, $order_how);
        }
    }

    public function contallAds(array $busca = array(), array $where = array(), array $wherein = array()) {
        $this->where_ins($wherein['ads.ads_cat_id']);
        $this->db->where('ads.ad_status', 2);
        $this->get_search($busca);
        $this->get_where($where);
        $this->db->join("ads_categories", "ads.ads_cat_id = ads_categories.ads_cat_id", "LEFT");
        $this->db->join("users", "ads.use_id = users.use_id", "LEFT");
        $query = $this->db->get("ads");
        return $query->num_rows();
    }

    public function listing($count = false, $limit = false, $offset = null, array $busca = array(), array $where = array(), array $wherein = array()) {


        $this->where_ins($wherein['ads.ads_cat_id']);
        $this->db->order_by('ads.ad_id', 'DESC');
        $this->db->where('ads.ad_status', 2);
        $this->get_search($busca);
        $this->get_where($where);
        $this->limite($limit, $offset);
        $this->db->join("ads_categories", "ads.ads_cat_id = ads_categories.ads_cat_id", "LEFT");
        $this->db->join("users", "ads.use_id = users.use_id", "LEFT");

        if ($count) {
            $count = $this->db->count_all_results("ads");

            return $count;
        } else {
            $query = $this->db->get("ads");
            //$this->db->last_query();
            $query = $query->result();
            if ($query) {
                return $query;
            } else {
                return false;
            }
        }
    }

    public function where_ins($parent) {
        if ((int) $parent > 0) {
            $dis = $this->getCategoriaFilho($parent);
            if (count($dis)) {
                foreach ($dis as $value) {
                    $ids[] .= $value->ads_cat_id;
                }
                return $this->db->where_in('ads.ads_cat_id', $ids);
            }
            return $this->db->where('ads.ads_cat_id', $parent);
        }
    }

    public function getCategoriaFilho($parent) {
        $this->db->where('ads_cat_parent', $parent);
        $this->db->where('ads_cat_status', 1);
        $query = $this->db->get("ads_categories");
        return $query->result();
    }

    /**
     * @param     $code
     * @param int $status
     *
     * @return array
     */
    public function details($code, $status = 2) {
        $this->db->where('ads.ad_id', $code);

        if ($status) {
            $this->db->where('ads.ad_status', $status);
        }

        $this->db->join("ads_categories", "ads.ads_cat_id = ads_categories.ads_cat_id", "LEFT");
        $this->db->join("users", "ads.use_id = users.use_id", "LEFT");

        $query = $this->db->get("ads");
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            return false;
        }
    }

    public function insert($data) {
        $this->db->insert("ads", $data);

        return $this->db->insert_id();
    }

    public function update($data, $code) {
        $this->db->where("ad_id", $code);
        $this->db->update("ads", $data);
    }

    public function delete($code) {
        $this->db->where("ad_id", $code);
        $query = $this->db->get("ads_images");
        $query = $query->result();
        if ($query):
            foreach ($query as $key => $value) {
                unlink($query[$key]->ads_img_path);

                $this->db->where("ads_img_id", $query[$key]->ads_img_id);
                $this->db->delete("ads_images");
            }
        endif;

        $this->db->where("ad_id", $code);
        $this->db->delete("ads");
    }

    public function status($code, $status) {
        $this->db->where("ad_id", $code);
        $this->db->set("ad_status", $status);
        $this->db->update("ads");
    }

    public function insertAreaAnnounce($area, $ad) {
        $this->db->set("area_id", $area);
        $this->db->set("ad_id", $ad);
        $this->db->insert("ads_areas");
    }

    public function areasDelete($code) {
        $this->db->where("ad_id", $code);
        $this->db->delete("ads_areas");
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

    public function related($limit = false, $code) {
        if ($limit) {
            $this->db->limit($limit);
        }

        $this->db->order_by("ad_id", "RANDOM");
        $this->db->where("ad_id <>", $code);
        $query = $this->db->get("ads");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }
    
    public function relatedHome($limit = false, $code) {
        if ($limit) {
            $this->db->limit($limit);
        }

        $this->db->order_by("ad_id", "RANDOM");
        $this->db->where("ad_id <>", $code);
        $query = $this->db->get("ads");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function categories($parent) {
        $this->db->order_by('ads_cat_name', 'ASC');
        $this->db->where('ads_cat_parent', $parent);
        $this->db->where('ads_cat_status', 1);
        $query = $this->db->get("ads_categories");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function categoriesDetails($code) {
        $this->db->where('ads_cat_id', $code);
        $query = $this->db->get("ads_categories");
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            return false;
        }
    }

    public function areas() {
        $this->db->order_by('area_name', 'ASC');
        $this->db->where('area_status', 1);
        $query = $this->db->get("areas");
        $query = $query->result();

        if ($query) {
            return $query;
        } else {
            return false;
        }
    }

    public function recordVisit($code, $visits) {
        $this->db->where("ad_id", $code);
        $this->db->set("ad_visits", $visits);
        $this->db->update("ads");
    }

    public function ads_item($data, $counter = false, $status = null) {
        $link = base_url('anuncio/' . $data->ad_slug);
        $category_parent = $this->categoriesDetails($data->ads_cat_parent);
        $categories = $category_parent->ads_cat_name . ' <i class="fa fa-angle-right" aria-hidden="true"></i> ' . $data->ads_cat_name;
        $images = $this->images($data->ad_id);
        $image = thumbnail(@$images[0]->ads_img_file, "ads", 200, 200, 2);

        if ($data->ad_use_info) {
            $city = $this->main_model->citiesDetails($data->use_city);
            $state = $this->main_model->statesDetails($data->use_state);
        } else {
            $city = $this->main_model->citiesDetails($data->ad_city);
            $state = $this->main_model->statesDetails($data->ad_state);
        }

        $city = resumeCidade(@$city->cit_name, 24);
        $state = @$state->sta_initials;
        $href = ($status != null && $status == 1) ? (null) : ('href="' . $link . '" target="_self" ');
        $id_status = ($status != null && $status == 1) ? (' ads__pending') : (null);
        $aspa = "'";
        $onclick = 'onclick="window.location="' . $aspa . $link . $aspa . '"';
        if ($this->session->userdata('login')) {
            $object = '
			<div 
			class="al-item' . $id_status . '" 
			data-name="' . strtolower($data->ad_name) . '" 
			data-price="' . ads_price_range($data->ad_price) . '"
			data-category="' . $category_parent->ads_cat_id . '"
			data-service="' . $data->ad_service . '"
			data-trade="' . $data->ad_trade . '"
			data-state="' . $state . '"
			data-region="' . $data->ad_region . '"
			data-city="' . $data->ad_city . '"
			data-neighborhood="' . $data->ad_neighborhood . '"
			>
				<div class="row">
					<div class="medium-3 columns">
						<div class="cover">
							<img alt="' . $data->ad_name . '" src="' . $image . '">
						</div>
						
					</div>
					<div class="medium-9 columns shophover">
                                         <a ' . $href . 'title="' . $data->ad_name . '">
						<div class="">
						    <div class="row" >
                                <div class="medium-12 columns">
                               
                                 <h3 class="title">' . resume($data->ad_name, 60) . (($data->ad_verified) ? '<i class="fa fa-check-circle-o verify"></i>' : '') . '</h3>
                                
                             </div>                                
							</div>
							<div class="row">                               
                                                    <div class="medium-8 columns desc">
                                                        <div>
                                                            <p class="category"><i class="fa fa-fw fa-folder"></i> ' . $categories . '</p>
                                                                                                    <p class="category show-for-small-only"><b><i class="fa fa-fw fa-calendar-check-o"></i> Publicado em:</b> ' . string_date_time($data->ad_timestamp) . '</p>
                                                            ' . (($images) ? '<span class="images hide-for-small-only"><i class="fa fa-fw fa-picture-o"></i> ' . count($images) . ' Imagens</span>' : '') . '
                                                        </div>
                                                    </div>
                                                     <div class="medium-4 columns">
                                                        <div class="more">
                                                            <span class="price">' .getDescAds($data, $category_parent->ads_cat_id). '</span>

                                                            ' . (($data->ad_trade) ? '<span class="change"><i class="fa fa-refresh"></i> Aceita Troca</span>' : '') . '
                                                        </div>
                                                    </div>
                                                </div>  
                                                                    </div>
						<div class="row">
							<div class="medium-12 columns">
								<ul class="infos">
								    ' . (($counter) ? '<li><div class="visits">' . (($data->ad_visits == 1) ? '1 visita' : $data->ad_visits . ' visitas') . '</div></li>' : '') . '
									<li><i class="fa fa-fw fa-map-marker"></i>' . $city . $state . '</li>
									' . (($data->use_phone) ? '<li><i class="fa fa-fw fa-phone"></i>' . $data->use_phone . '</li>' : '') . '
									<li><i class="fa fa-fw fa-calendar-check-o"></i>' . string_date_time($data->ad_timestamp) . '</li>
								</ul>
							</div>
						</div>
                                              
					</div>  </a>
				</div>
			</div>		
        ';     
        } else {
            $object = '
			<div 
			class="al-item' . $id_status . '" 
			data-name="' . strtolower($data->ad_name) . '" 
			data-price="' . ads_price_range($data->ad_price) . '"
			data-category="' . $category_parent->ads_cat_id . '"
			data-service="' . $data->ad_service . '"
			data-trade="' . $data->ad_trade . '"
			data-state="' . $state . '"
			data-region="' . $data->ad_region . '"
			data-city="' . $data->ad_city . '"
			data-neighborhood="' . $data->ad_neighborhood . '"
			>
				<div class="row">
					<div class="medium-3 columns">
						<div class="cover">
							<img alt="' . $data->ad_name . '" src="' . $image . '">
						</div>
						
					</div>
					<div class="medium-9 columns shophover">
                                         <a ' . $href . 'title="' . $data->ad_name . '">
						<div class="">
						    <div class="row" >
                                <div class="medium-12 columns">
                               
                                 <h3 class="title">' . resume($data->ad_name, 60) . (($data->ad_verified) ? '<i class="fa fa-check-circle-o verify"></i>' : '') . '</h3>
                                
                             </div>                                
							</div>
							<div class="row">                               
                                                    <div class="medium-8 columns desc">
                                                        <div>
                                                            <p class="category"><i class="fa fa-fw fa-folder"></i> ' . $categories . '</p>
                                                                                                    <p class="category show-for-small-only"><b><i class="fa fa-fw fa-calendar-check-o"></i> Publicado em:</b> ' . string_date_time($data->ad_timestamp) . '</p>
                                                            ' . (($images) ? '<span class="images hide-for-small-only"><i class="fa fa-fw fa-picture-o"></i> ' . count($images) . ' Imagens</span>' : '') . '
                                                        </div>
                                                    </div>
                                                     <div class="medium-4 columns">
                                                        <div class="more">
                                                            <span class="price">' .getDescAds($data, $category_parent->ads_cat_id). '</span>

                                                            ' . (($data->ad_trade) ? '<span class="change"><i class="fa fa-refresh"></i> Aceita Troca</span>' : '') . '
                                                        </div>
                                                    </div>
                                                </div>  
                                                                    </div>
						<div class="row">
							<div class="medium-12 columns">
								<ul class="infos">
								    ' . (($counter) ? '<li><div class="visits">' . (($data->ad_visits == 1) ? '1 visita' : $data->ad_visits . ' visitas') . '</div></li>' : '') . '
									<li><i class="fa fa-fw fa-map-marker"></i>' . $city . $state . '</li>
                                    <li><i class="fa fa-fw fa-phone"></i> Entre para ver</li>
									<li><i class="fa fa-fw fa-calendar-check-o"></i>' . string_date_time($data->ad_timestamp) . '</li>
								</ul>
							</div>
						</div>
                                              
					</div>  </a>
				</div>
			</div>		
            
        ';     
        }
        return $object;
    }

    public function images($code, $hash = false) {
        if ($hash) {
            $this->db->where('ad_hash', $code);
        } else {
            $this->db->where('ad_id', $code);
        }

        $query = $this->db->get("ads_images");
        $query = $query->result();

        return $query;
    }

    public function imagesDetails($code) {
        $this->db->where("ads_img_id", $code);
        $query = $this->db->get("ads_images");
        $query = $query->result();

        return $query[0];
    }

    public function imagesInsert($data) {
        $this->db->insert("ads_images", $data);

        return $this->db->insert_id();
    }

    public function imagesDelete($code) {
        $this->db->where("ads_img_id", $code);
        $this->db->delete("ads_images");
    }

    public function imagesSetAds($hash, $ad) {
        $this->db->where('ad_hash', $hash);
        $this->db->set('ad_id', $ad);
        $this->db->update('ads_images');
    }

    public function cleanImagesHashs($code) {
        $this->db->where('ad_id', $code);
        $this->db->set('ad_hash', '');
        $this->db->update('ads_images');
    }

    public function verifyShop($user) {
        $this->db->limit(1);
        $this->db->where('use_id', $user);
        $query = $this->db->get("shops");
        $query = $query->result();

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function getBySlug($slug) {
        $this->db->limit(1);
        $this->db->where("ad_slug", $slug);
        $query = $this->db->get("ads");
        $query = $query->result();

        if ($query) {
            return $query[0];
        } else {
            return false;
        }
    }

    public function adsCount($status = 2) {
        $this->db->where("ad_status", $status);
        return $this->db->count_all_results("ads");
    }

    public function areaCheck($ad, $area) {
        $this->db->where('ad_id', $ad);
        $this->db->where('area_id', $area);
        $query = $this->db->get("ads_areas");
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