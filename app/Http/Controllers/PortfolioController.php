<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Controllers\CalculateController;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class PortfolioController extends Controller
{
    public function getAll()
    {
        $portfolios = User::find((Auth::id()))->portfolios()->paginate(10);
        $currentGoldPrice = (new CalculateController)->getGoldPrice();
        $currentGoldPrice = $currentGoldPrice["items"][0]["xauPrice"] / 31.1035;
        return view('portfolio', ['data' => $portfolios]);
    }

    public function getTransactions(Request $req)
    {
        $currentGoldPrice = (new CalculateController)->type($req)["currentGoldPrice_USDg"];

        return [
            "currentGoldPrice" => $currentGoldPrice,
            "transactionsData" => User::find(Auth::id())->transactions()->where('type', '=', $req->type)->get()
        ];
    }

    public function add(Request $req)
    {
    }

    public function update(Request $req)
    {
    }

    public function delete(Request $req)
    {
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'buyDate' => ['required', 'date'],
            'goldPrice' => ['required', 'numeric', 'gt:0'],
            'downpayment' => ['required', 'numeric', 'gt:0'],
            'convertPercent' => ['required', 'numeric', 'min:0'],
            'managementFeePercent' => ['required', 'numeric', 'min:0'],
        ]);
    }
}
