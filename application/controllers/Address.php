<?php
/**
 * Created by PhpStorm.
 * User: Vinícius
 * Date: 05/10/2016
 * Time: 21:43
 */


/**
 * Class Address
 *
 * @property Address_model $address_model
 * @property Main_model $main_model
 */
class Address extends CI_Controller
{	
    public function filter()
    {   
        if(isset($_POST['state'])):
            $state = $this->address_model->getState($_POST['state']);
            $regions = $this->address_model->getRegions($state);
            $this->main_model->printJson($regions);
        endif;

        if(isset($_POST['region'])):
            $city = $this->address_model->getCity($_POST['region']);
            $this->main_model->printJson($city);
        endif;
       
        
    }
    public function getByCep($str, $method){
        switch ($method) {
            case 'regions':
                $regions = $this->address_model->getRegions($str);
                $this->main_model->printJson($regions);
                break;
            case 'city':
                $city = $this->address_model->getCity($str);
                $this->main_model->printJson($city);
                break;
            case 'neighborhood':
                $neighborhood = $this->address_model->getNeighborhood($str);
                $this->main_model->printJson($neighborhood);
                break;
            default:
                $this->address_model->setPostalCode($str);
                $address = $this->address_model->getArrayFromData();
                $this->main_model->printJson($address);
                break;
        }

    }
}