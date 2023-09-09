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

    public function portfolio(){

    }

    public function transactions(){
        
    }

    public function transactionsPerPortfolio(){

    }
}
