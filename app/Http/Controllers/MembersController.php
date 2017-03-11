<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Member;
use App\Contribution;
use DB;
use Carbon\Carbon;


class MembersController extends Controller
{
    public function getMembers()
    {
        $members = Member::orderBy('last_name')->get();
        return $members;
    }

    public function getChamberType($chamber)
    {
        $members = Member::where('chamber', $chamber)->get();
        return $members;
    }

    public function getCongressData($chamber)
    {
        $client = new Client();
        $res = $client->request('get', 'https://api.propublica.org/congress/v1/114/' . $chamber . '/members.json', [
            'headers' => [
                'X-Api-key' => 'PPo8NOUWRG9i9WcBKJVIVacNERznlT50adGL56wN'
            ]
        ]);


        $members = json_decode($res->getBody())->results[0]->members;
        foreach ($members as $member)
        {
            Member::create(
                [
                    'first_name'     => $member->first_name,
                    'middle_name'    => $member->middle_name,
                    'last_name'      => $member->last_name,
                    'state'          => $member->state,
                    'party'          => $member->party,
                    'chamber'        => ucwords($chamber),
                    'next_election'  => $member->next_election,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ]
            );
        };
    }

    public function getOpenSecret() {
    	$client = new Client();
    	$res = $client->request('get', 'http://www.opensecrets.org/api/?method=candSummary&cid=N00007360&cycle=2012&apikey=e70c0d7425b91027c3c566a9c298c50a&output=json');
    	dd(json_decode($res->getBody()));
    }

    public function clearData()
    {
        Member::truncate();
    }

    public function getCidData() {
   		\Excel::load('cpid.xls', function($reader) {
			    $cpidResults = $reader->get();
			    $cpidResults = $reader->all();
			    $member = collect();

			    foreach ($cpidResults as $result)
        	{
        		$name = explode(", ", $result->crpname);
        		$middle = explode(" ", implode(" ", $name)); //splitting the middle name
        		$last_name = $name[0];
        		$first_name = $middle[1];
        		$member->push(
        			[
        			    $result->cid,
        				$last_name,
        				$first_name,
        				Member::where('last_name', $last_name)->where('first_name', $first_name)->update(['cid' => $result->cid]),
        				Member::where('last_name', $last_name)->where('first_name', $first_name)->get(),
                        Contribution::where('cid',  $result->cid)->get()
        			]
        		);
        	}
			    echo(json_encode($member));
			});
    }

    public function getContributors()
    {
        $contributors = Contribution::all();
        echo($contributors);
    }

    public function fillContribution()
    {
        $members = Member::WhereNotNull('cid')->get();
        $client = new Client();
        foreach ($members as $member)
        {
            $res = $client->request('get', 'https://www.opensecrets.org/api/?method=candContrib&cid=' .  $member->cid . '&cycle=2016&apikey=e70c0d7425b91027c3c566a9c298c50a&output=json');
            $response = json_decode($res->getBody(), true);
            $contributors = $response['response']['contributors']['contributor'];
            $attributes = $response['response']['contributors']['@attributes'];
            $cid = $attributes['cid'];
            $cycle = $attributes['cycle'];
            $notice = $attributes['notice'];

            foreach ($contributors as $contributor)
            {
                Contribution::create(
                    [
                        'cid'                   =>  $cid,
                        'organization_name'     =>  $contributor['@attributes']['org_name'],
                        'total'                 =>  $contributor['@attributes']['total'],
                        'cycle'                 =>  $cycle,
                        'notice'                =>  $notice,
                        'pacs'                  =>  $contributor['@attributes']['pacs'],
                        'indivs'                =>  $contributor['@attributes']['indivs'],
                    ]
                );
            };
        }
    }

}
