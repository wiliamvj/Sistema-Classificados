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
header("Content-type: text/html; charset=utf-8");
class Address extends MY_Controller
{	

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