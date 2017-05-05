<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Helpers\ClimateApi;

class ClimateController extends Controller
{
	public function __construct()
	{
		$this->owm = New ClimateApi('481e3bc28e5264e5607c2b65b449bfc1');
	}

    public function index(Request $request){
    	return view('index')->with([
    		'city_name' => !empty($request->city_name)? $request->city_name : null,
    		'climate' => !empty($request->city_name)? $this->owm->getWeather($request->city_name) : null
		]);
    }
}
