<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Bill;

// https://api.propublica.org/congress/v1/{congress}/{chamber}/bills/{type}.json

class BillsController extends Controller {

	public function getBillsData() {
		$requestUrl = 'https://api.propublica.org/congress/v1/';
	  $congress = [];
	  $congress = range('105', '114');
	  $chamber_senate = 'senate';
	  $chamber_house = 'house';
	  $types = ['introduced', 'updated', 'passed', 'major'];
	  function requestBillsData($url) {
	  	$client = new Client();
	  	$request = $client->request('get',$url, [
	  	    'headers' => [
	  	        'X-Api-key' => 'PPo8NOUWRG9i9WcBKJVIVacNERznlT50adGL56wN'
	  	    ]
	  	]);
	  	// ADD to DB
	  	$bills = json_decode($request->getBody())->results[0]->bills;
	  	foreach ($bills as $bill) {
	  	    Bill::create(
	  	        [
	  	            'bill_number'       => $bill->number,
	  	            'bill_uri'          => $bill->bill_uri,
	  	            'title'             => $bill->title,
	  	            'introduced_date'   => $bill->introduced_date,
	  	            'cosponsors'        => $bill->cosponsors,
	  	            'committees'        => $bill->committees,
	  	            'latest_major_action_date' => $bill->latest_major_action_date,
	  	            'latest_major_action' => $bill->latest_major_action,
	  	            'created_at'     => Carbon::now(),
	  	            'updated_at'     => Carbon::now(),
	  	        ]
	  	    );
	  	};
	  }
		foreach ($congress as $congress_term ) {
			$requestUrl_senate = $requestUrl . $congress_term . '/' . $chamber_senate . '/bills/';
			$requestUrl_house = $requestUrl . $congress_term . '/' . $chamber_house . '/bills/';
			foreach ($types as $type ) {
				$requestUrl_senate = $requestUrl_senate . $type . '.json';
				$requestUrl_house = $requestUrl_house . $type . '.json';
				// Make Request
				requestBillsData($requestUrl_senate);
				requestBillsData($requestUrl_house);
				// Reset Request URL
				$requestUrl_senate = $requestUrl . $congress_term . '/' . $chamber_senate . '/bills/';
				$requestUrl_house = $requestUrl . $congress_term . '/' . $chamber_house . '/bills/';
			}
		}


	}
	public function getBills() {
	    $bills = Bill::all();
	    return $bills;
	}
	public function clearBillData() {
		Bill::truncate();
	}
}
