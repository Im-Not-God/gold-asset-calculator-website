<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    //
    public static function index(){
        $plan = User::find(Auth::id())->plan()->first();
        return $plan;
    }

    public function subscribePlan(Request $req){
        $plan = Plan::find($req->planId);
        if($plan){
            $user = User::find(Auth::id());
            $user->plan_id = $req->planId;
            $user->save();
            session()->flash("subscribeMessage","Subscribe to $plan->type");
            return redirect("/plan");
        }
    }

    public static function portfoliosLimit(){
        $plan = self::index();
        $numOfPortfolios = User::find(Auth::id())->portfolios->count();
        if(explode(",", $plan->detail)[0] - $numOfPortfolios <= 0){
            return true;
        }
        return false;
    }

    public static function transactionsLimit(){
        $plan = self::index();
        $numOfTransactions = User::find(Auth::id())->transactions->count();
        if(explode(",", $plan->detail)[1] - $numOfTransactions  <= 0){
            return true;
        }
        return false;
    }

    public static function transactionsPerPortfolioLimit($numOfTransactions){
        $plan = self::index();
        if(explode(",", $plan->detail)[2] - $numOfTransactions  < 0){
            return true;
        }
        return false;
    }

    public function transactionsPerPortfolioLimit_req(Request $req){
        $plan = self::index();
        if(explode(",", $plan->detail)[2] - $req->numOfTransactions  < 0){
            return true;
        }
        return false;
    }
}
