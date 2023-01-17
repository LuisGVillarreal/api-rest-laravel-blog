<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller{
    public function test(Request $request){
        return "Action 'test' from CategoryController";
    }
}
