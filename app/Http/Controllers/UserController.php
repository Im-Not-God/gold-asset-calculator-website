<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function getPost(){
        return User::find(2)->getPost;
    }

    // public function checkAdmin(){
    //     return Admin::find(1)->user->name;
    // }
}
