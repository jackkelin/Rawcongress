<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Carbon\Carbon;
use DB;
use App\Bill;

// https://api.propublica.org/congress/v1/{congress}/{chamber}/bills/{type}.json

class BillsController extends Controller 
{

	public function getBillsData() 
	{
	  $requestUrl = 'https://api.propublica.org/congress/v1/';
	  $congress = [];
	  $congress = range('105', '115');
	  $chamber_senate = 'senate';
	  $chamber_house = 'house';
	  $types = ['introduced', 'updated', 'passed', 'major'];

	  function requestBillsData($url) {
	  	// add to db
	  	$request = Controller::proRequest($url);
	  	$bills = json_decode($request->getBody())->results[0]->bills;
	  	foreach ($bills as $bill) {
	  		$bill_id = Controller::uriToId($bill->bill_uri);
				$member_id = Controller::uriToId($bill->sponsor_uri);
	  	    Bill::create(
  	        [
	            'bill_num' => $bill->number,
	            'bill_uri' => $bill->bill_uri,
	            'bill_id' => $bill_id,
	            'bill_title' => $bill->title,
	            'bill_intro_date' => $bill->introduced_date,
	            'bill_cosponsors' => $bill->cosponsors,
	            'bill_sponsor_id' => $member_id, 		
	            'bill_committees' => $bill->committees,
	            'bill_latest_major_action_date' => $bill->latest_major_action_date,
	            'bill_latest_major_action' => $bill->latest_major_action,
	            'created_at'     => Carbon::now(),
	            'updated_at'     => Carbon::now(),
  	        ]
	  	    );
	  	};
	  }

		foreach ($congress as $congress_term ) 
		{
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
				//getBillUri();
			}
		}
	}
	public function getBillUri()
	{
		// Request Bill uri - reference db
		$get_bill_uris = DB::table('bills')->pluck('bill_uri');
		foreach ($get_bill_uris as $bill_uri)
		{
			$request = Controller::proRequest($bill_uri);
			$request = json_decode($request->getBody())->results[0];
			// DB::table('bills')
	  //     ->where('bill_uri', $bill_uri)
	  //     ->update('bill_summary' => $request->summary)
	  //     ->update('bill_congress_term' => $request->congress)
	  //     ->update('bill_pdf' => $request->gpo_pdf_uri);

			// Bill::where('bill_uri', $bill_uri)
	  //     ->update(['bill_summary' => $request->summary])
	  //     ->update(['bill_congress_term' => $request->congress])
	  //     ->update(['bill_pdf' => $request->gpo_pdf_uri]); 

      Bill::where('bill_uri', $bill_uri)->update(['bill_summary' => $request->summary], ['bill_congress_term' => $request->congress], ['bill_pdf' => $request->gpo_pdf_uri]);
		}
	}
	public function getBills() 
	{
	    $bills = Bill::all();
	    return $bills;
	}
	public function clearBillData() 
	{
		Bill::truncate();
	}
}
