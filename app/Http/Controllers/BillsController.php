<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Bill;

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
	  		$resURLParam = [];
	  		array_push($congress_term, $resURLParam);
	  		array_push($chamber_senate, $resURLParam);
	  		foreach ($types as $type ) {
	  			$request = $client->request('get','blah');
	  		}


	  	}
	    $client = new Client();
	    $res = $client->request('get', 'https://api.propublica.org/congress/v1/114/house/bills/introduced.json', [
	        'headers' => [
	            'X-Api-key' => 'PPo8NOUWRG9i9WcBKJVIVacNERznlT50adGL56wN'
	        ]
	    ]);

	    $bills = json_decode($res->getBody())->results[0]->bills;
	    foreach ($bills as $bill)
	    {
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
	public function getBills() {
	    $bills = Bill::all();
	    return $bills;
	}
}
