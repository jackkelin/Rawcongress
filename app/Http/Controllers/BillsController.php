<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Member;


class BillsController extends Controller
{
	public function getBillsData() {
	  $congress = ['113', '114'];
	  $chamber_senate = 'senate';
	  $chamber_house = 'house';
	  $types = ['introduced', 'updated', 'passed', 'major'];
	  $resURL = 'https://api.propublica.org/congress/v1/';
	  $client = new Client();
	  $request;
	  //https://api.propublica.org/congress/v1/{congress}/{chamber}/bills/{type}.json
	  	foreach ($congress as $congress_term ) {
	  		$senateURL = $resURL . $congress_term . '/' . $chamber_senate . '/bills/';
	  		$houseURL = $resURL . $congress_term . '/' . $chamber_house . '/bills/';
	  		foreach ($types as $type ) {
	  			$senateURL = $senateURL . $type . '.json';
	  			$houseURL = $houseURL . $type . '.json';
	  			echo '<br>';
	  			echo $senateURL;
	  			echo '<br>';
	  			echo $houseURL;
	  			echo '<br>';			
		  		$senateURL = $resURL . $congress_term . '/' . $chamber_senate . '/bills/';
		  		$houseURL = $resURL . $congress_term . '/' . $chamber_house . '/bills/';
	  		}  
	  	}
	}
	public function getBills() {
	    $bills = Bill::all();
	    return $bills;
	}
}
