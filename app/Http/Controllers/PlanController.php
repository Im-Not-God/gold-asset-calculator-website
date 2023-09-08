<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class PlanController extends Controller
{
    //
    public function getAll()
    {
        $data = Plan::all();
        $details = array();
        foreach ($data as $plan)
            array_push($details, explode(",", $plan->detail));

        return view(request()->path() == 'admin' ?  'admin.plan' : 'plan', ['data' => $data, 'details' => $details]);
    }

    public function update(Request $req)
    {
        $req->validate([
            'price.*' => ['required', 'numeric', 'min:0'],
            'detail0.*' => ['required', 'numeric', 'min:-1'],
            'detail1.*' => ['required', 'numeric', 'min:-1'],
        ]);
        foreach ($req->id as $index => $id) {
            $plan = Plan::find($id);
            $plan->price = $req->price[$index];
            $plan->detail = $req->detail0[$index].",".$req->detail1[$index];
            $plan->updated_at = null;
            $plan->save();
        }

        return redirect('/admin');
    }
}
