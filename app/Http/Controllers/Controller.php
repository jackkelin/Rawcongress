<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use GuzzleHttp\Client;
use App\Member;
use DB;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function uriToId($uri)
    {
        $id = $uri;
        $id = explode('/', $id);
        $id = end($id);
        $id = explode('.', $id);
        $id = $id[0];
        return $id;
    }
    // Propublica Request
    public static function proRequest($url)
    {
      $client = new Client();
      $request = $client->request('get',$url, [
          'headers' => [
              'X-Api-key' => 'PPo8NOUWRG9i9WcBKJVIVacNERznlT50adGL56wN'
          ]
      ]);
      return $request;
    }
}
