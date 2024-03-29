<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TransactionController extends Controller
{
    public function getAll()
    {
        $validationFail = session()->has('validationFail') ? session('validationFail') : 'false';
        $data = User::find(Auth::id())->transactions()->paginate(10);
        $getCurrentGoldPrice = APIController::getGoldPrice()["goldPrice"] / 31.1035;
        $transactionsLimit = SubscriptionController::transactionsLimit();
        return view('transaction', ['data' => $data, 'currentGoldPrice' => $getCurrentGoldPrice, 'validationFail' => $validationFail, 'transactionsLimit'=>$transactionsLimit]);
    }

    public function add(Request $req)
    {
        if (!SubscriptionController::transactionsLimit()) {
            $validator = $this->validator($req->all());

            session()->flash('validationFail', $validator->fails() ? 'true' : 'false');

            $validator->validate();

            $exchangeRate = 1;

            if ($req->currency == "MYR")
                $exchangeRate = APIController::getExchange($req->currency, $req->buyDate)['rate'];

            if ($req->type == "Other") {
                Transaction::create([
                    'user_id' => Auth::id(),
                    'type' => $req->type,
                    'downpayment' => number_format($req->downpayment / $exchangeRate, 2, '.', ''),
                    'gold_price' => number_format($req->goldPrice / $exchangeRate, 2, '.', ''),
                    'convert_percent' => $req->convertPercent,
                    'management_fee_percent' => $req->managementFeePercent,
                    'created_at' => $req->buyDate,
                ]);
            } else {
                Transaction::create([
                    'user_id' => Auth::id(),
                    'type' => $req->type,
                    'downpayment' => number_format($req->downpayment / $exchangeRate, 2, '.', ''),
                    'gold_price' => number_format($req->goldPrice / $exchangeRate, 2, '.', ''),
                    'created_at' => $req->buyDate,
                ]);
            }
        }

        return redirect('/transaction');
    }

    public function update(Request $req)
    {
        $validator = $this->validator($req->all());
        session()->flash('validationFail', $validator->fails() ? 'true' : 'false');
        $validator->validate();

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

        return redirect('/transaction');
    }

    public function delete(Request $req)
    {
        // $transactions = Transaction::query();
        foreach ($req->transactions as $value) {
            // $transactions->orWhere('id', '=', $value);
            $portfolioIDs = Transaction::find($value)->portfolios()->allRelatedIds();
            Transaction::find($value)->portfolios()->detach();

            foreach ($portfolioIDs as $portfolioID) {
                $portfolio = Portfolio::find($portfolioID);
                $numOfTransactions = $portfolio->transactions()->count();
                if ($numOfTransactions > 0) {
                    $portfolio->num_of_transactions = $numOfTransactions;
                    $portfolio->save();
                } else {
                    $portfolio->delete();
                }
            }

            Transaction::find($value)->delete();
        }
        // $transactions = $transactions->delete();

        return redirect('/transaction');
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

    public function calculateHandler(Request $req)
    {
        $transactions = Transaction::query();
        foreach ($req->transactions as $value) {
            $transactions->orWhere('id', '=', $value);
        }
        $transactions = $transactions->get();

        return (new CalculateController)->transaction_calc($transactions, "transaction");
    }
}
