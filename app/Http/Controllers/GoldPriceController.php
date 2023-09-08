<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GoldPriceController extends Controller
{
    //
    public function index(Request $req){
        $client = new Client();
        $response = $client->get("https://bigjndufwr.wsictqm.com.my/Setups.svc/GetPrice/" . $req->currencyCode . "/" . $req->packageCode, ['verify' => false]);
        if ($response->getStatusCode() == 200) { // 200 OK
            $response_data = $response->getBody()->getContents();
            $json = json_decode($response_data, true);
            return $json;
        }
    }
}
