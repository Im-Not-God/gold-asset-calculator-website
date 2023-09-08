<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class testController extends Controller
{
    public function index()
    {
        return view('test');
    }
}
