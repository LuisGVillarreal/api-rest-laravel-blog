<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Category;

class CategoryController extends Controller{

	function __construct($foo = null){
		$this->middleware('api.auth', ['except' => ['index', 'show']]);
	}

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

	//Save
	public function store(Request $request){
		$json = $request->input('json', null);
		$params_array = json_decode($json, true);

		if (!empty($params_array)) {
			$validate = \Validator::make($params_array, [
				'name'	=> 'required'
			]);
			if ($validate->fails()) {
				$store = [
		        	'status'	=> "Error",
		        	'code'		=> 400,
		        	'message'	=>  $validate->errors()
		        ];
			} else {
				$category = new Category();
				$category->name = $params_array['name'];
				$category->save();
				$store = [
		        	'status'	=> "Success",
		        	'code'		=> 200,
		        	'category'	=> $category,
		        ];
			}
		} else {
			$store = [
		       	'status'	=> "Error",
		       	'code'		=> 400,
		       	'message'	=> "Data sent are not correct"
		    ];
		}
		return response()->json($store, $store['code']);
	}

	//Update
	public function update($id, Request $request){
		$json = $request->input('json', null);
		$params_array = json_decode($json, true);

		if (!empty($params_array)) {
			$validate = \Validator::make($params_array, [
				'name'	=> 'required'
			]);
			unset($params_array['id']);
			unset($params_array['created_at']);

			if ($validate->fails()) {
				$store = [
		        	'status'	=> "Error",
		        	'code'		=> 400,
		        	'message'	=>  $validate->errors()
		        ];
			} else {
				$category = Category::where('id', $id)->update($params_array);
				$store = [
		        	'status'	=> "Success",
		        	'code'		=> 200,
		        	'category'	=> $params_array
		        ];
			}
		}else{
			$store = [
		       	'status'	=> "Error",
		       	'code'		=> 400,
		       	'message'	=> "Data sent are not correct"
		    ];
		}
		return response()->json($store, $store['code']);
	}
}
