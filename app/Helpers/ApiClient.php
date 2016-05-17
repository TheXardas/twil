<?php


namespace App\Helpers;

use GuzzleHttp\Client;

class ApiClient {


    public function get($url)
    {
        $client = new Client([
            'base_uri' => $url
        ]);
    }
}