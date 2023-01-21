<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Category;

class CategoryController extends Controller{

	//Get all categories
    public function index(){
    	$categories = Category::all();
        return response()->json([
        	'status'		=> "success",
        	'code'			=> 200,
        	'categories'	=> $categories
        ]);
    }

	//Get a category
	public function show($id) {
		$category = Category::find($id);
		if (is_object($category)) {
			$category = array(
	        	'status'		=> "success",
	        	'code'			=> 200,
	        	'category'		=> $category
	        );
		} else {
			$category = array(
	        	'status'		=> "Error",
	        	'code'			=> 404,
	        	'message'		=> "Category is not found",
	        );
		}
		return response()->json($category, $category['code']);
	}


}
