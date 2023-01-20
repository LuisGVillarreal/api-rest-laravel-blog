<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller{

	public function test(Request $request){
		return "Action 'test' from UserController";
	}

	public function register(Request $request){
		//Get user data by Post
		$json = $request->input("json", null);
		$params = json_decode($json);
		$params_array = array_map('trim', json_decode($json, true)); //Clean

		if (!empty($params) && !empty($params_array)) {
			//Validate data
			$validate = \Validator::make($params_array, [
				'name'		=> 'required|alpha',
				'surname'	=> 'required|alpha',
				'email'		=> 'required|email|unique:users',
				'password'	=> 'required'
			]);

			if ($validate->fails()) {
				$data = array(
					'status'	=> 'error',
					'code'		=> 400,
					'message'	=> "User has not been created",
					'errors'	=> $validate->errors()
				);
			}else{
				//Save user
				$user = new User();
				$user->name = $params_array['name'];
				$user->surname = $params_array['surname'];
				$user->role = "USER";
				$user->email = $params_array['email'];
				$user->password = \Hash::make($params->password);
				$user->save();

				$data = array(
					'status'	=> 'success',
					'code'		=> 200,
					'message'	=> "User created successfully",
					'user'		=> $user
				);
			}
		}else{
			$data = array(
				'status'	=> 'error',
				'code'		=> 400,
				'message'	=> "Data sent are not correct"
			);
		}

		return response()->json($data, $data['code']);
	}

	public function login(Request $request){
		$JwtAuth = new \JwtAuth();
		//Get user credential by Post
		$json = $request->input("json", null);
		$params = json_decode($json);
		$params_array = json_decode($json, true);

		//Validate credential
		$validate = \Validator::make($params_array, [
			'email'		=> 'required|email',
			'password'	=> 'required'
		]);
		if ($validate->fails()) {
			$signup = array(
				'status'	=> 'error',
				'code'		=> 422,
				'message'	=> "Invalid data",
				'errors'	=> $validate->errors()
			);
		}else{
			$signup = $JwtAuth->signup($params->email, $params->password);
			if (!empty($params->getToken)) {
				$signup = $JwtAuth->signup($params->email, $params->password, true);
			}
		}
		return response()->json($signup, $signup['code']);
	}

	public function update(Request $request){
		$token = $request->header("Authorization");
		$JwtAuth = new \JwtAuth();
		$checkToken = $JwtAuth->checkToken($token);

		if ($checkToken) {
			echo "<h1>Login Correcto</h1>";
		}else{
			echo "<h1>Login Incorrecto</h1>";
		}
		die();
	}
}
