<?php

namespace App\Helpers;

use Illuminate\Support\Collection;

class ClimateApi{

	public function __construct($AppID) {
		if ( empty($AppID) )
			abort(401, 'Empty API key');

		$this->AppID = $AppID;
		$this->collection = New Collection;
	}

	public function getWeather($q){
		$curl = curl_init();
		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'http://api.openweathermap.org/data/2.5/forecast/daily?mode=json&units=metric&cnt=5&APPID='.$this->AppID.'&q='.$q,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		if($err)
		{
			abort(500, $err);
		}
		curl_close($curl);

		$response = json_decode($response);

		if( empty($response) )
			abort(500, 'Empty Result, Please Check Your Connection');
	    else if( $response->cod != 200 )
	    	abort($response->cod, $response->message);
	    
		$result = new \stdClass();
		$result->city_name = $response->city->name;
		$result->lists = [];

		foreach($response->list as $key => $l){
			$data = new \stdClass();
			$data->date = date('Y-m-d', $l->dt);
			$data->temperature = $l->temp->day;
			$data->variance = $l->temp->max - $l->temp->min;

			$result->lists[] = $data;
		}
		return $result;
	}
}