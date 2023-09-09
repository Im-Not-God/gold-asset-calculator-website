<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class APIController extends Controller
{
    //
    public static function getExchange($str = "MYR", $time = "latest")
    {
        $apiKey = "W2HREI6uelhoxk43D8TkdRGeeXXWR92j";
        $client = new Client();
        $next = false;
        try {
            $response = $client->get("https://api.apilayer.com/exchangerates_data/$time?symbols=$str&base=USD", ['verify' => false, 'headers' => ["apikey" => $apiKey]]);
            if ($response->getStatusCode() == 200) { // 200 OK
                $response_data = $response->getBody()->getContents();
                $json = json_decode($response_data, true);
                return [
                    "data" => $json,
                    "timestamp" => $json["timestamp"],
                    "rate" => $json['rates']['MYR']
                ];
            }
        } catch (Exception $e) {
            $next = true;
        }

        if ($next) {
            $next = false;
            $url = "";
            try {
                if ($time == "latest") {
                    $url = "https://api.apilayer.com/currency_data/live?source=USD&currencies=$str";
                } else {
                    $url = "https://api.apilayer.com/currency_data/historical?date=$time";
                }
                $response = $client->get($url, ['verify' => false, 'headers' => ["apikey" => $apiKey]]);
                if ($response->getStatusCode() == 200) { // 200 OK
                    $response_data = $response->getBody()->getContents();
                    $json = json_decode($response_data, true);
                    return [
                        "data" => $json,
                        "timestamp" => $json["timestamp"],
                        "rate" => $json['quotes']['USDMYR']
                    ];
                }
            } catch (Exception $e) {
                $next = true;
            }
        }
    }

    public static function getGoldPrice($str = "USD")
    {
        $client = new Client();
        //free 100/mon 1hrs upd --metalpriceapi.com
        //$response = $client->get('https://api.metalpriceapi.com/v1/latest?api_key=bdeacda07a5f20d95f4760815d6dd69a&base=XAU&currencies=USD',['verify' => false]);
        //free 100/mon 2sec upd --goldapi.io
        //$response = $client->get('https://www.goldapi.io/api/XAU/'.$str, ['verify' => false, 'headers' => ['x-access-token' => 'goldapi-18rvhwrlefik3sb-io']]);
        $response = $client->get('https://data-asg.goldprice.org/dbXRates/' . $str, ['verify' => false]);
        if ($response->getStatusCode() == 200) { // 200 OK
            $response_data = $response->getBody()->getContents();
            $json = json_decode($response_data, true);
            return [
                "data" => $json,
                "timestamp" => $json["ts"],
                "goldPrice" => $json["items"][0]["xauPrice"]
            ];
        }
    }

    public static function getQMData()
    {
        $currencyCode = "MYR";
        $packageCode = "GOLDACCOUNT";

        $client = new Client();
        $response = $client->get("https://bigjndufwr.wsictqm.com.my/Setups.svc/GetPrice/" . $currencyCode . "/" . $packageCode, ['verify' => false]);
        if ($response->getStatusCode() == 200) { // 200 OK
            $response_data = $response->getBody()->getContents();
            $json = json_decode($response_data, true);
            return [
                "data" => $json,
                "goldPrice" => $json["GetPriceResult"]["SpotPrice"],
            ];
        }
    }
}
