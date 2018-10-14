<?php
/**
 * Created by PhpStorm.
 * User: bislewl
 * Date: 10/13/2018
 * Time: 9:37 PM
 */
require_once('NHTSA/vehicles.php');

class NHTSA{

	function __construct(){

	}

	protected function apiRequest($apiURL, $method, $type = array(), $params = array(), $format = 'json', $http_method = 'GET'){
		$return = array();
		$apiURL .= implode($method, '/') . '/';
		if(isset($type) && is_array($type)){
			$apiURL .= implode('/', $type);
		}
		if(!isset($params['format'])){
			$params['format'] = $format;
		}
		if(isset($params) && is_array($params)){
			$apiURL .= http_build_query($params);
		}
		if(isset($params)){
			$opts = array(
				'http' => array(
					'method' => strtoupper($http_method),
					'header' => "Accept-language: en\r\n",
				),
			);
		}
		$context = stream_context_create($opts);
		$fp      = fopen($apiURL, 'rb', false, $context);
		if(!$fp){
			$return['error'][] = 'Bad Request';
		}
		$response = @stream_get_contents($fp);
		if($response == false){
			$return['error'][] = 'No Response';
		}
		$return['result'] = $response;

		return $return;
	}


}