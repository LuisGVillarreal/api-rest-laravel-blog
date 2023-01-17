<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller{
    
    public function test(Request $request){
        return "Action 'test' from UserController";
    }

    public function register(Request $request){
        $name = $request->input('name');
        $surname = $request->input('surname'); 
        return "Action 'register' from User. Name: $name $surname";
    }

    public function login(Request $request){
        return "Action 'login' from User";
    }
}
