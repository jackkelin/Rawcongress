<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use GuzzleHttp\Client;
use DB;
use App\Member;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMembers()
    {
        $members = Member::all();
        return $members;
    }

    public function getCongressData()
    {
        $client = new Client();
        $res = $client->request('get', 'https://api.propublica.org/congress/v1/114/house/members.json', [
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
                    'next_election' => $member->next_election,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ]
            );
        };
    }

    public function clearData()
    {
        Member::truncate();
    }
}
