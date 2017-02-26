<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Member;
use DB;
use Carbon\Carbon;

class MembersController extends Controller
{
    public function getMembers()
    {
        $members = Member::all();
        return $members;
    }

    public function getChamberType($chamber)
    {
        $members = Member::where('chamber', $chamber)->get();
        return $members;
    }

    public function getCongressData()
    {
    	$chamber = 'senate';
        $client = new Client();
        $res = $client->request('get', 'https://api.propublica.org/congress/v1/114/' . $chamber . '/members.json', [
            'headers' => [
                'X-Api-key' => 'PPo8NOUWRG9i9WcBKJVIVacNERznlT50adGL56wN'
            ]
        ]);

        dd(json_decode($res->getBody()));

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
}
