<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;


class CalculateController extends Controller
{
    public $constantData = null;

    function calc($req, $report = 0)
    {
        if ($req->goldPrice == null) {
            if (!$report)
                return redirect('/calculator');
            // return redirect('/transaction');
        }

        if ($report) {
            if ($this->constantData == null) {
                $this->constantData = $this->type($req);
            }
        }

        $goldPrice = ($report) ? $req->gold_price : $req->goldPrice;
        // $currency = ($report) ? $req->currency : "USD";
        // $downpayment_USD = ($report) ? (($currency == "MYR") ? $req->downpayment*APIController::getExchange(null ,$req->buyDate) : $req->downpayment) : $req->downpayment_USD;
        $downpayment_USD = ($report) ? ($req->downpayment) : $req->downpayment_USD;
        $totalHoldingGold = $downpayment_USD / $goldPrice;
        $totalHoldingGold = $downpayment_USD / $goldPrice;
        $convertPercent = ($report) ? $this->constantData["convertPercent"] / 100 : $req->convertPercent / 100;
        $managementFeePercent = ($report) ? $this->constantData["managementFeePercent"] / 100 : $req->managementFeePercent / 100;
        $convert_USD = $downpayment_USD * $convertPercent;
        $holdingAmt = $downpayment_USD - $convert_USD;
        $GCAmt = $convert_USD / $goldPrice;

        $getCurrentGoldPrice = null;
        if ($report) {
            $getCurrentGoldPrice = $this->constantData["currentGoldPrice_USDg"];
        } else {
            if (session("getCurrentGoldPrice")) {
                $getCurrentGoldPrice = session()->get("getCurrentGoldPrice");
            } else {
                $getCurrentGoldPrice = $this->getGoldPrice();
            }
        }
        // $currentGoldPrice_USDtroyoz = $getCurrentGoldPrice["rates"]["USD"];
        // $currentGoldPrice_USDg = $currentGoldPrice_USDtroyoz / 31.1035;
        //$currentGoldPrice_USDg = $getCurrentGoldPrice["price_gram_24k"];

        $currentGoldPrice_USDg = ($report) ? $getCurrentGoldPrice : $getCurrentGoldPrice["items"][0]["xauPrice"] / 31.1035;
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $currentGoldPrice_updTime = "";
        if ($report) {
            $currentGoldPrice_updTime = $this->constantData["currentGoldPrice_updTime"];
        } else {
            if (strlen((string)$getCurrentGoldPrice["ts"]) - strlen((string)time())  > 2) {
                $currentGoldPrice_updTime = gmdate("Y-m-d H:i:s", $getCurrentGoldPrice["ts"] / 1000 + date("Z"));
            } else {
                $currentGoldPrice_updTime = gmdate("Y-m-d H:i:s", $getCurrentGoldPrice["ts"] + date("Z"));
            }
        }

        $exchangeRate = null;
        if ($report) {
            $exchangeRate = $this->constantData["exchangeRate"];
        } else {
            if (session("exchangeRate")) {
                $exchangeRate = session()->get("exchangeRate");
            } else {
                $exchangeRate = APIController::getExchange();
            }
        }

        $terminateDate = date("Y-m-d");
        $currentValue = $currentGoldPrice_USDg * $totalHoldingGold;
        $days = date_diff(date_create(($report) ? $req->created_at : $req->buyDate), date_create($terminateDate))->format("%a");
        $managementFee_day = $convert_USD * $managementFeePercent / 365;
        $managementFee_total = $managementFee_day * $days;
        $netCashOut = $currentValue - $convert_USD - $managementFee_total;
        $profit = $netCashOut - $holdingAmt;
        //$profit = $currentValue - $downpayment_USD - $managementFee_total;

        $exchangeRate_updTime = "";
        if ($report) {
            $exchangeRate_updTime = $this->constantData["exchangeRate_updTime"];
        } else {
            if (strlen((string)$exchangeRate['timestamp']) - strlen((string)time())  > 2) {
                $exchangeRate_updTime = gmdate("Y-m-d H:i:s", $exchangeRate['timestamp'] / 1000 + date("Z"));
            } else {
                $exchangeRate_updTime = gmdate("Y-m-d H:i:s", $exchangeRate['timestamp'] + date("Z"));
            }
        }

        return [
            'buyDate' => ($report) ? $req->created_at : $req->buyDate,
            'goldPrice' => $goldPrice,
            'downpayment_USD' => $downpayment_USD,
            'totalHoldingGold' => $totalHoldingGold,
            'convertPercent' => $convertPercent * 100,
            'managementFeePercent' => $managementFeePercent  * 100,
            'convert_USD' => $convert_USD,
            'convert_MYR' => $convert_USD * (($report) ? $exchangeRate : $exchangeRate['rate']),
            'holdingAmt_USD' => $holdingAmt,
            'holdingAmt_MYR' => $holdingAmt * (($report) ? $exchangeRate : $exchangeRate['rate']),
            'GCAmt' => $GCAmt,
            'currentGoldPrice_USDg' => $currentGoldPrice_USDg,
            'currentGoldPrice_updTime' => $currentGoldPrice_updTime,
            'exchangeRate' => ($report) ? $exchangeRate : $exchangeRate['rate'],
            'exchangeRate_updTime' => $exchangeRate_updTime,


            'terminateDate' => $terminateDate,
            'currentValue_USD' => $currentValue,
            'currentValue_MYR' => $currentValue * (($report) ? $exchangeRate : $exchangeRate['rate']),
            'days' => $days,
            'managementFee_day_USD' => $managementFee_day,
            'managementFee_day_MYR' => $managementFee_day * ($report) ? $exchangeRate :  $exchangeRate['rate'],
            'managementFee_total_USD' => $managementFee_total,
            'managementFee_total_MYR' => $managementFee_total * (($report) ? $exchangeRate : $exchangeRate['rate']),
            'netCashOut_USD' => $netCashOut,
            'netCashOut_MYR' => $netCashOut * (($report) ? $exchangeRate : $exchangeRate['rate']),
            'profit_USD' => $profit,
            'profit_MYR' => $profit * (($report) ? $exchangeRate : $exchangeRate['rate']),
        ];
    }

    public function type($transaction)
    {
        switch ($transaction->type) {
            case "QM": {
                    $result = $this->getQMData()["GetPriceResult"];
                    $currentGoldPrice = $result["SpotPrice"];
                    $exchangeRate = 1;
                    $updateDT = 0;
                    foreach ($result["PackagePrices"] as $data) {
                        if ($data["code"] == "QMGSA") {
                            $exchangeRate = $data["BuyRate"];
                            $updateDT = $data["UpdateDT"];
                            break;
                        }
                    }
                    $currentGoldPrice_updTime = date_format(date_create($updateDT), "Y-m-d H:i:s");
                    $exchangeRate_updTime = date_format(date_create($updateDT), "Y-m-d H:i:s");
                    return [
                        'convertPercent' => 91,
                        'managementFeePercent' => 3.5,
                        'currentGoldPrice_USDg' => $currentGoldPrice,
                        'exchangeRate' => $exchangeRate,
                        'currentGoldPrice_updTime' => $currentGoldPrice_updTime,
                        'exchangeRate_updTime' => $exchangeRate_updTime,
                    ];
                }
            case "Other": {
                    $currentGoldPrice = $this->getGoldPrice();
                    $currentGoldPrice_USDg = $currentGoldPrice["items"][0]["xauPrice"] / 31.1035;
                    $exchangeRate = APIController::getExchange();

                    if (strlen((string)$currentGoldPrice["ts"]) - strlen((string)time())  > 2) {
                        $currentGoldPrice_updTime = gmdate("Y-m-d H:i:s", $currentGoldPrice["ts"] / 1000 + date("Z"));
                    } else {
                        $currentGoldPrice_updTime = gmdate("Y-m-d H:i:s", $currentGoldPrice["ts"] + date("Z"));
                    }

                    if (strlen((string)$exchangeRate['timestamp']) - strlen((string)time())  > 2) {
                        $exchangeRate_updTime = gmdate("Y-m-d H:i:s", $exchangeRate['timestamp'] / 1000 + date("Z"));
                    } else {
                        $exchangeRate_updTime = gmdate("Y-m-d H:i:s", $exchangeRate['timestamp'] + date("Z"));
                    }
                    return [
                        'convertPercent' => $transaction->convert_percent,
                        'managementFeePercent' => $transaction->management_fee_percent,
                        'currentGoldPrice_USDg' =>  $currentGoldPrice_USDg,
                        'exchangeRate' => $exchangeRate,
                        'currentGoldPrice_updTime' => $currentGoldPrice_updTime,
                        'exchangeRate_updTime' => $exchangeRate_updTime,
                    ];
                }
        }
    }

    public function output(Request $req)
    {
        $req->validate([
            'buyDate' => ['required', 'date'],
            'goldPrice' => ['required', 'numeric', 'gt:0'],
            'downpayment_USD' => ['required', 'numeric', 'gt:0'],
        ]);
        $result = $this->calc($req);
        //return $req;
        return view("calculator", $result);
    }

    public function index()
    {
        $getCurrentGoldPrice = $this->getGoldPrice();
        session()->put("getCurrentGoldPrice", $getCurrentGoldPrice);
        $currentGoldPrice_USDg = $getCurrentGoldPrice["items"][0]["xauPrice"] / 31.1035;
        date_default_timezone_set('Asia/Kuala_Lumpur');
        $currentGoldPrice_updTime = "";
        if (strlen((string)$getCurrentGoldPrice["ts"]) - strlen((string)time())  > 2) {
            $currentGoldPrice_updTime = gmdate("Y-m-d H:i:s", $getCurrentGoldPrice["ts"] / 1000 + date("Z"));
        } else {
            $currentGoldPrice_updTime = gmdate("Y-m-d H:i:s", $getCurrentGoldPrice["ts"] + date("Z"));
        }
        $exchangeRate = APIController::getExchange();
        session()->put("exchangeRate", $exchangeRate);

        $exchangeRate_updTime = "";
        if (strlen((string)$exchangeRate['timestamp']) - strlen((string)time())  > 2) {
            $exchangeRate_updTime = gmdate("Y-m-d H:i:s", $exchangeRate['timestamp'] / 1000 + date("Z"));
        } else {
            $exchangeRate_updTime = gmdate("Y-m-d H:i:s", $exchangeRate['timestamp'] + date("Z"));
        }

        return view('calculator', [
            'buyDate' => null,
            'goldPrice' => null,
            'downpayment_USD' => null,
            'currentGoldPrice_USDg' => number_format($currentGoldPrice_USDg, 2, '.', ''),
            'currentGoldPrice_updTime' => $currentGoldPrice_updTime,
            'exchangeRate' => number_format($exchangeRate['rate'], 2, '.', ''),
            'exchangeRate_updTime' => $exchangeRate_updTime,
            'convertPercent' => 91,
            'managementFeePercent' => 3.5,

        ]);
    }

    public function getGoldPrice($str = "USD")
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
            return $json;
        }
    }

    public function getQMData()
    {
        $currencyCode = "MYR";
        $packageCode = "GOLDACCOUNT";

        $client = new Client();
        $response = $client->get("https://bigjndufwr.wsictqm.com.my/Setups.svc/GetPrice/" . $currencyCode . "/" . $packageCode, ['verify' => false]);
        if ($response->getStatusCode() == 200) { // 200 OK
            $response_data = $response->getBody()->getContents();
            $json = json_decode($response_data, true);
            return $json;
        }
    }



    //1 USD to MYR
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
            $url ="";
            try {
                if($time == "latest"){
                    $url ="https://api.apilayer.com/currency_data/live?source=USD&currencies=$str";
                }else{
                    $url ="https://api.apilayer.com/currency_data/historical?date=$time";
                }
                $response = $client->get($url, ['verify' => false, 'headers' => ["apikey" => $apiKey]]);
                if ($response->getStatusCode() == 200) { // 200 OK
                    $response_data = $response->getBody()->getContents();
                    $json = json_decode($response_data, true);
                    return [
                        "data" => $json,
                        "timestamp" => $json["timestamp"],
                        "rate" => $json['quotes']['USDMYR']
                    ];;
                }
            } catch (Exception $e) {
                $next = true;
            }
        }
    }

    public function transaction_calc(Request $req)
    {
        // $cdata = $this->index(1);
        $transactions = Transaction::query();
        foreach ($req->transactions as $value) {
            $transactions->orWhere('id', '=', $value);
        }
        $transactions = $transactions->get();

        $results = [];
        $sum_totalHoldingGold = 0;
        $sum_convert_USD = 0;
        $sum_holdingAmt_USD = 0;
        $sum_GCAmt = 0;
        $sum_currentValue_USD = 0;
        $sum_managementFee_total_USD = 0;
        $sum_netCashOut_USD = 0;
        $sum_profit_USD = 0;
        $sum_downpayment_USD = 0;

        foreach ($transactions as $transaction) {
            $result = (object) $this->calc($transaction, 1);
            $sum_totalHoldingGold += $result->totalHoldingGold;
            $sum_convert_USD += $result->convert_USD;
            $sum_holdingAmt_USD += $result->holdingAmt_USD;
            $sum_GCAmt += $result->GCAmt;
            $sum_currentValue_USD += $result->currentValue_USD;
            $sum_managementFee_total_USD += $result->managementFee_total_USD;
            $sum_netCashOut_USD += $result->netCashOut_USD;
            $sum_profit_USD += $result->profit_USD;
            $sum_downpayment_USD += $transaction->downpayment;
            array_push($results, $result);
        }
        $sum = [
            $sum_totalHoldingGold, $sum_convert_USD, $sum_holdingAmt_USD, $sum_GCAmt, $sum_currentValue_USD, $sum_managementFee_total_USD, $sum_netCashOut_USD,
            $sum_profit_USD, $sum_downpayment_USD
        ];
        // $result = (object) $result[0];
        // return $result;
        //return $result[0]->totalHoldingGold;
        //return gettype($this->calc($transactions[0], 1));

        return view('report', ['data' => $transactions, 'cdata' => $this->constantData, 'result' => $results, 'summary' => $sum]);
    }

    // public function transaction_summary_calc($results)
    // {
    //     $sum_totalHoldingGold = 0;
    //     $sum_convert_USD = 0;
    //     $sum_holdingAmt_USD = 0;
    //     $sum_GCAmt = 0;
    //     $sum_currentValue_USD = 0;
    //     $sum_managementFee_total_USD = 0;
    //     $sum_netCashOut_USD = 0;
    //     $sum_profit_USD = 0;

    //     foreach ($results as $result) {
    //         $sum_totalHoldingGold += $result->totalHoldingGold;
    //         $sum_convert_USD += $result->convert_USD;
    //         $sum_holdingAmt_USD += $result->holdingAmt_USD;
    //         $sum_GCAmt += $result->GCAmt;
    //         $sum_currentValue_USD += $result->currentValue_USD;
    //         $sum_managementFee_total_USD += $result->managementFee_total_USD;
    //         $sum_netCashOut_USD += $result->netCashOut_USD;
    //         $sum_profit_USD += $result->profit_USD;
    //     }
    // }
}
