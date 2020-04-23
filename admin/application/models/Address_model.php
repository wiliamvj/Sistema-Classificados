<?php
/**
 * Created by PhpStorm.
 * User: Vinícius
 * Date: 05/10/2016
 * Time: 21:42
 */

/**
 * @property CI_DB_query_builder $db
 * @property Main_model          $main_model
 */
class Address_model extends CI_Model
{
    private $states;
    private $state_id;

    private $cities;
    private $city_id;

    private $neighborhoods;
    private $neighborhood_id;
    private $inNeighborhoods;

    private $regions;
    private $region_id;

    private $addressText;
    private $postalCode;


    private function selectSates()
    {
        $this->db->select('sta_name as name,sta_id as state_id');
        $query = $this->db->get('states');
        $arrayStates = $query->result('array');

        $this->states = $arrayStates;
    }

    private function selectCities()
    {
        if(!$this->state_id){
            return;
        }

        if($this->state_id) {
            $this->db->where_in('sta_id', $this->state_id);

            $this->db->select('cit_name as name,cit_id as city_id');
            $query = $this->db->get('cities');
            $arrayCities = $query->result('array');

            $this->cities = $arrayCities;
        }

    }

    private function selectNeighborhoods()
    {
        if(!$this->inNeighborhoods && !$this->city_id){
            return;
        }

        if($this->city_id){
            $this->db->where_in('cit_id',$this->city_id);
        }

        $this->db->select('bairro_nome as name,bairro_id as neighborhood_id');
        $query = $this->db->get('bairro');

        $arrayBairros = $query->result('array');

        $this->neighborhoods = $arrayBairros;
    }

    private function selectRegions()
    {
        if(!$this->state_id){
            return;
        }

        $this->db->where('sta_id', $this->state_id);
        $state = $this->db->get('states');
        $state = $state->result();
        $state = $state[0]->sta_name;


        $this->db->where('estado_temp',$state);


        $this->db->select('regiao_nome as name,regiao_id as region_id');
        $query = $this->db->get('regiao');

        $arrayRegioes = $query->result('array');

        $this->regions = $arrayRegioes;
    }

    public function getRegions($str)
    {
        $this->db->where('sta_id', $str);
        $state = $this->db->get('states');
        $state = $state->result();
        $state = $state[0]->sta_name;

        $this->db->where('estado_temp',$state);
        $this->db->select('regiao_nome as name,regiao_id as region_id');

        $query = $this->db->get('regiao');
        $return['regions'] = $query->result('array');

        return $return;
    }

    public function getCity($str)
    {
        $this->db->where('regiao_id', $str);
        $this->db->select('cit_name as name, cit_id as city_id');

        $query = $this->db->get('cities');
        $return['cities'] = $query->result('array');

        return $return;
    }

    public function getNeighborhood($str)
    {
        $this->db->where('cit_id', $str);
        $this->db->select('bairro_nome as name, bairro_id as neighborhood_id');

        $query = $this->db->get('bairro');
        $return['neighborhoods'] = $query->result('array');

        return $return;
    }

    private function selectAddress()
    {
        $this->db->select('logradouro,cep.cit_id,bairros,cities.sta_id,cities.regiao_id');
        $this->db->where('cep',$this->postalCode);

        $this->db->join('cities', 'cities.cit_id = cep.cit_id','left');
        $query = $this->db->get('cep');

        $arrayCep = $query->result('array');
        if(is_array($arrayCep[0])){
            $arrayCep = $arrayCep[0];

            $this->addressText = $arrayCep['logradouro'];
            $this->city_id = $arrayCep['cit_id'];
            $this->state_id = $arrayCep['sta_id'];
            $this->region_id = $arrayCep['regiao_id'];

            //$this->inNeighborhoods = $arrayCep['bairros'];
            $neighborhoods = explode(',', $arrayCep['bairros']);
            $this->neighborhood_id = $neighborhoods[0];
        }


    }

    private function selectAddressData(){
        $this->selectAddress();
        $this->selectSates();
        $this->selectCities();
        $this->selectNeighborhoods();
        $this->selectRegions();


    }

    private function buildArrayFromData()
    {
        $addressData['states'] = $this->states;
        $addressData['state_id'] = $this->state_id;

        $addressData['cities'] = $this->cities;
        $addressData['city_id'] = $this->city_id;

        $addressData['neighborhoods'] = $this->neighborhoods;
        $addressData['neighborhood_id'] = $this->neighborhood_id;

        $addressData['regions'] = $this->regions;
        $addressData['region_id'] = $this->region_id;

        $addressData['addressText'] = $this->addressText;

        return $addressData;

    }

    public function getArrayFromData(){
        $this->selectAddressData();

        $addressData = $this->buildArrayFromData();

        return $addressData;
    }

    public function setPostalCode($postalCode){
        $postalCode = preg_replace('/[^0-9]/','',$postalCode);

        $this->postalCode = $postalCode;
    }


}