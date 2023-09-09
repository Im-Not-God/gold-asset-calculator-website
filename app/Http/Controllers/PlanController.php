<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    //
    public function getAll()
    {
        $data = Plan::all();
        $details = array();
        foreach ($data as $plan)
            array_push($details, explode(",", $plan->detail));

        if(Auth::check())
            $planSubscribed = SubscriptionController::index();
        else
            $planSubscribed = null;

        return view(request()->path() == 'admin' ?  'admin.plan' : 'plan', ['data' => $data, 'details' => $details, 'planSubscribed' => $planSubscribed]);
    }

    public function update(Request $req)
    {
        $this->validator($req->all())->validate();

        foreach ($req->id as $index => $id) {
            $plan = Plan::find($id);
            $plan->price = $req->price[$index];
            $details = array();
            foreach($req->detail as $detail){
                $details[] = $detail[$index];
            }
            $plan->detail = implode(",",$details);
            // $plan->detail = $req->detail[0][$index].",".$req->detail[1][$index].",".$req->detail[2][$index];
            $plan->updated_at = null;
            $plan->save();
        }

        return redirect('/admin');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'price.*' => ['required', 'numeric', 'min:0'],
            'detail' => ['required', 'array'],
            'detail.0.*' => ['required', 'numeric', 'min:-1'],
            'detail.1.*' => ['required', 'numeric', 'min:-1'],
            'detail.2.*' => ['required', 'numeric', 'min:-1'],
        ])->setAttributeNames([
            'price.*' => 'price',
            'detail.0.*' => 'number of portfolio',
            'detail.1.*' => 'number of transactions',
            'detail.2.*' => 'number of transactions per portfolio',
        ]);
    }
}
