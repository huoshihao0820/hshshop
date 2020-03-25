<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){
        return view('/login/login');
    }
    public function login_do(){

    }
    public function register(){
        return view('login/register');
    }
}
