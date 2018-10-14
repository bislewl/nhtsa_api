<?php
/**
 * Created by PhpStorm.
 * User: bislewl
 * Date: 10/14/2018
 * Time: 12:39 AM
 */

namespace NHTSA;
class vehicles{

	private function apiVehiclesRequest($method, $type = array(), $params = array(), $format = 'json', $http_method = 'GET'){
		$base_url = 'https://vpic.nhtsa.dot.gov/api/';
		$method[] = 'vehicles';
		$return   = $this->apiRequest($base_url, $method, $type, $params, $format, $http_method);

		return $return;
	}

	// Decode VIN
	public function decodeVin($vin, $modelyear = ''){
		$method[] = 'vehicles';
		$method[] = 'decodeVin';
		$type[]   = $vin;
		$params   = ($modelyear != '') ? array('modelyear' => $modelyear) : array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Decode VIN (flat format) in a Batch
	public function DecodeVINValuesBatch($vins_array){
		$method[]    = 'vehicles';
		$method[]    = 'DecodeVINValuesBatch';
		$data_string = '';
		foreach($vins_array as $vin_array){
			$data_string .= (is_array($vin_array)) ? $vin_array['vin'] . $vin_array['modelyear'] : $vin_array['vin'];
		}
		$type     = array();
		$params   = array('DATA' => $data_string);
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json', 'POST');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Decode VIN (flat format)
	public function DecodeVinValues($vin, $modelyear = ''){
		$method[] = 'vehicles';
		$method[] = 'DecodeVinValues';
		$type[]   = $vin;
		$params   = ($modelyear != '') ? array('modelyear' => $modelyear) : array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Decode VIN Extended
	public function decodeVinExtended($vin, $modelyear = ''){
		$method[] = 'vehicles';
		$method[] = 'decodeVin';
		$type[]   = $vin;
		$params   = ($modelyear != '') ? array('modelyear' => $modelyear) : array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Decode VIN Extended(flat format)
	public function DecodeVinValuesExtended($vin, $modelyear = ''){
		$method[] = 'vehicles';
		$method[] = 'DecodeVinValues';
		$type[]   = $vin;
		$params   = ($modelyear != '') ? array('modelyear' => $modelyear) : array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Decode WMI
	public function DecodeWMI($wmi){
		$method[] = 'vehicles';
		$method[] = 'DecodeWMI';
		$type[]   = $wmi;
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Decode SAE WMI
	public function DecodeSAEWMI($wmi){
		$method[] = 'vehicles';
		$method[] = 'DecodeSAEWMI';
		$type[]   = $wmi;
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Decode WMI for Manufacturer
	public function DecodeWMIForManufacturer($mfg){
		$method[] = 'vehicles';
		$method[] = 'DecodeWMIForManufacturer';
		$type[]   = $mfg;
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Decode SAE WMI for Manufacturer
	public function DecodeSAEWMIForManufacturer($mfg){
		$method[] = 'vehicles';
		$method[] = 'DecodeSAEWMIForManufacturer';
		$type[]   = $mfg;
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get All Makes
	public function GetAllMakes(){
		$method[] = 'vehicles';
		$method[] = 'GetAllMakes';
		$type     = array();
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Parts
	public function GetParts($type_of_org, $fromDate = '', $toDate = ''){
		$method[]           = 'vehicles';
		$method[]           = 'GetParts';
		$fromDate           = ($fromDate == '') ? date('m/d/Y') : date('m/d/Y', strtotime($fromDate));
		$toDate             = ($toDate == '') ? date('m/d/Y') : date('m/d/Y', strtotime($toDate));
		$type               = array();
		$params['type']     = $type_of_org;
		$params['fromDate'] = $fromDate;
		$params['toDate']   = $toDate;
		$more_pages         = true;
		$params['page']     = 1;
		$return             = array();
		while($more_pages != false){
			$response    = $this->apiVehiclesRequest($method, $type, $params, 'json');
			$return_page = json_decode($response, true, JSON_PRETTY_PRINT);
			if($return_page['Count'] != 0){
				$return['Results'] = array_merge($return['Results'], $return_page['Results']);
				$return['Count']   = $return['Count'] + $return_page['Count'];
			} else{
				$more_pages = false;
			}
			$params['page'] = $params['page'] + 1;
		}

		return $return;
	}


	// Get All Manufacturers
	public function GetAllManufacturers(){
		$method[]       = 'vehicles';
		$method[]       = 'GetAllManufacturers';
		$type           = array();
		$more_pages     = true;
		$params['page'] = 1;
		$return         = array();
		while($more_pages != false){
			$response    = $this->apiVehiclesRequest($method, $type, $params, 'json');
			$return_page = json_decode($response, true, JSON_PRETTY_PRINT);
			if($return_page['Count'] != 0){
				$return['Results'] = array_merge($return['Results'], $return_page['Results']);
				$return['Count']   = $return['Count'] + $return_page['Count'];
			} else{
				$more_pages = false;
			}
			$params['page'] = $params['page'] + 1;
		}

		return $return;
	}

	// Get Manufacturer Details
	public function GetManufacturerDetails($mfg){
		$method[] = 'vehicles';
		$method[] = 'GetManufacturerDetails';
		$type     = array($mfg);
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Manufacturer Details
	public function GetMakesForManufacturer($mfg){
		$method[] = 'vehicles';
		$method[] = 'GetMakesForManufacturer';
		$type     = array($mfg);
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Makes for Manufacturer by Manufacturer Name and Year
	public function GetMakesForManufacturerAndYear($mfg, $year){
		$method[] = 'vehicles';
		$method[] = 'GetMakesForManufacturerAndYear';
		$type     = array($mfg);
		$params   = array('year' => $year);
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Makes for Vehicle Type by Vehicle Type Name
	public function GetMakesForVehicleType($veh_type){
		$method[] = 'vehicles';
		$method[] = 'GetMakesForVehicleType';
		$type     = array($veh_type);
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Vehicle Types for Make by Name
	public function GetVehicleTypesForMake($make){
		$method[] = 'vehicles';
		$method[] = 'GetVehicleTypesForMake';
		$type     = array($make);
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Equipment Plant Codes
	public function GetEquipmentPlantCodes($year){
		$method[] = 'vehicles';
		$method[] = 'GetEquipmentPlantCodes';
		$type     = array($year);
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Models for Make
	public function GetModelsForMake($make){
		$method[] = 'vehicles';
		$method[] = 'GetModelsForMake';
		$type     = array($make);
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Models for MakeId
	public function GetModelsForMakeId($make_id){
		$method[] = 'vehicles';
		$method[] = 'GetModelsForMakeId';
		$type     = array($make_id);
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Models for Make and a combination of Year and Vehicle Type
	public function GetModelsForMakeYear($make, $year, $veh_type = ''){
		$method[] = 'vehicles';
		$method[] = 'GetModelsForMakeYear';
		$type     = array('make', $make);
		if($year != ''){
			$type = array_merge($type, array('modelyear', $year));
		}
		if($veh_type != ''){
			$type = array_merge($type, array('vehicletype', $veh_type));
		}
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Models for Make Id and a combination of Year and Vehicle Type
	public function GetModelsForMakeIdYear($make_id, $year, $veh_type = ''){
		$method[] = 'vehicles';
		$method[] = 'GetModelsForMakeIdYear';
		$type     = array('makeId', $make_id);
		if($year != ''){
			$type = array_merge($type, array('modelyear', $year));
		}
		if($veh_type != ''){
			$type = array_merge($type, array('vehicletype', $veh_type));
		}
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Vehicle Variables List
	public function GetVehicleVariableList(){
		$method[] = 'vehicles';
		$method[] = 'GetVehicleVariableList';
		$type     = array();
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Vehicle Variable Values List
	public function GetVehicleVariableValuesList($variable){
		$method[] = 'vehicles';
		$method[] = 'GetVehicleVariableValuesList';
		$type     = array($variable);
		$params   = array();
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}

	// Get Canadian vehicle specifications
	public function GetCanadianVehicleSpecifications($year, $make, $model = '', $units = 'Metric'){
		$method[] = 'vehicles';
		$method[] = 'GetVehicleVariableList';
		$type     = array();
		$params   = array(
			'year'  => $year,
			'make'  => $make,
			'model' => $model,
			'untis' => $units,
		);
		$response = $this->apiVehiclesRequest($method, $type, $params, 'json');
		$return   = json_decode($response, true, JSON_PRETTY_PRINT);

		return $return;
	}
}