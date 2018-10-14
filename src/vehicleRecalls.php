<?php
/**
 * Created by PhpStorm.
 * User: bislewl
 * Date: 10/14/2018
 * Time: 12:56 AM
 */

namespace NHTSA;

class vehicleRecalls{

	private function apiVehicleRecallsRequest($method, $type = array(), $params = array(), $format = 'json', $http_method = 'GET'){
		$base_url = 'https://one.nhtsa.gov/webapi/api/Recalls/vehicle/';
		$return   = $this->apiRequest($base_url, $method, $type, $params, $format, $http_method);

		return $return;
	}

	public function campaignNumber($campaign_number){
		$method[] = 'campaignnumber';
		$type[]   = $campaign_number;
		$return   = $this->apiVehicleRecallsRequest($method, $type, array(), 'json', 'GET');

		return $return;
	}

	public function getVehicleRecalls($year = '', $make = '', $model = ''){
		if($year != '' && $make != '' && $model != ''){
			$method = array($year, $make, $model);
		} elseif($year != '' && $make != ''){
			$method = array($year, $make);
		} elseif($year != ''){
			$method = array($year);
		} else{
			$method = array();
		}

		$return = $this->apiVehicleRecallsRequest($method, array(), array(), 'json', 'GET');

		return $return;
	}
}