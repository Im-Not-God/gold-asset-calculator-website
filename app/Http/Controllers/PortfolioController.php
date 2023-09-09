<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Http\Controllers\CalculateController;
use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function getAll()
    {
        $this->checkData();
        $portfolios = User::find((Auth::id()))->portfolios()->paginate(10);
        $currentGoldPrice = APIController::getGoldPrice()["goldPrice"] / 31.1035;
        return view('portfolio', ['data' => $portfolios]);
    }

    public function checkData()
    {
        $portfolios = User::find((Auth::id()))->portfolios()->get();
        foreach ($portfolios as $portfolio) {
            $numOfTransactions = $portfolio->transactions()->allRelatedIds()->count();
            if ($numOfTransactions > 0) {
                $portfolio->num_of_transactions = $numOfTransactions;
                $portfolio->save();
            } else {
                $portfolio->delete();
            }
        }
    }

    public function getTransactions(Request $req)
    {
        if ($req->type == "QM") {
            $currentGoldPrice = APIController::getQMData()["goldPrice"];
        } else {
            $currentGoldPrice = APIController::getGoldPrice()["goldPrice"];
        }

        return [
            "currentGoldPrice" => $currentGoldPrice,
            "transactionsData" => User::find(Auth::id())->transactions()->where('type', '=', $req->type)->get()
        ];
    }

    public function add(Request $req)
    {
        $portfolioId = Portfolio::create([
            'user_id' => Auth::id(),
            'type' => $req->type,
            'num_of_transactions' => count($req->transactions),
        ])->id;

        Portfolio::find($portfolioId)->transactions()->attach($req->transactions);

        return redirect('/portfolio');
    }

    public function update(Request $req)
    {
        $exchangeRate = 1;

        if ($req->currency == "MYR")
            $exchangeRate = APIController::getExchange($req->currency, $req->buyDate)['rate'];

        $transaction = Transaction::find($req->id);
        $transaction->downpayment = number_format($req->downpayment / $exchangeRate, 2, '.', '');
        $transaction->gold_price = number_format($req->goldPrice / $exchangeRate, 2, '.', '');
        if ($req->type == "Other") {
            $transaction->convert_percent = $req->convertPercent;
            $transaction->management_fee_percent = $req->managementFeePercent;
        }
        $transaction->created_at = $req->buyDate;
        $transaction->save();

        return redirect('/portfolio');
    }

    public function getOnlyTransactionsUnderPortfolio()
    {
    }

    public function delete(Request $req)
    {
        // $portfolios = Portfolio::query();
        foreach ($req->portfolios as $value) {
            // $portfolios->orWhere('id', '=', $value);

            Portfolio::find($value)->transactions()->detach();
            Portfolio::find($value)->delete();
        }
        // $portfolios->transactions()->detach();

        // $portfolios->delete();



        //return redirect('/portfolio');
    }
}
