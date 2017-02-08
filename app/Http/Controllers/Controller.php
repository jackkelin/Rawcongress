<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use GuzzleHttp\Client;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function getCongressApiData()
    {
        $client = new Client();
        $res = $client->request('get', 'https://api.propublica.org/congress/v1/114/house/members.json', [
            'headers' => [
                'X-Api-key' => 'PPo8NOUWRG9i9WcBKJVIVacNERznlT50adGL56wN'
            ]
        ]);
        $data = [json_decode($res->getBody())->results[0]->members];
        return $data;
    }
}
