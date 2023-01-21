<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class UserController extends Controller{

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
		//Auth
		$token = $request->header("Authorization");
		$JwtAuth = new \JwtAuth();
		$checkToken = $JwtAuth->checkToken($token);
		$json = $request->input('json', null);
		$params_array = json_decode($json, true);

		if ($checkToken && !empty($params_array)) {
			//Update user
			$user = $JwtAuth->checkToken($token, true);
			$validate = \Validator::make($params_array, [
				'name'		=> 'required|alpha',
				'surname'	=> 'required|alpha',
				'email'		=> 'required|email|unique:users,'.$user->sub,
			]);

			unset($params_array['id']);
			unset($params_array['role']);
			unset($params_array['password']);
			unset($params_array['created_at']);
			unset($params_array['remember_token']);

			$user_update = User::where('id', $user->sub)->update($params_array);

			$update = array(
				'status'	=> 'success',
				'code'		=> 200,
				'user'		=> $user,
				'change'	=> $params_array
			);
		}else{
			$update = array(
				'status'	=> 'error',
				'code'		=> 401,
				'message'	=> "User is not authenticated"
			);
		}
		return response()->json($update, $update['code']);
	}

	public function upload(Request $request){
		//Get data
		$image = $request->file('file0');
		$validate = \Validator::make($request->all(), [
				'file0'	=> 'required|image|mimes:jpg,jpeg,png,gif'
			]);
		if ($image && !$validate->fails()) {
			$image_name = time().$image->getClientOriginalName();
			\Storage::disk('users')->put($image_name, \File::get($image));
			$data = array(
				'status'	=> 'succes',
				'code'		=> 200,
				'image'		=> $image_name
			);
		}else{
			$data = array(
				'status'	=> 'error',
				'code'		=> 400,
				'message'	=> "Uploaded data error"
			);
		}
		return response()->json($data, $data['code']);
	}

	public function getImage($filename){
		$isset = \Storage::disk('users')->exists($filename);
		if ($isset) {
			$file = \Storage::disk('users')->get($filename);
			return new Response($file, 200);
		}else{
			$data = array(
				'status'	=> 'error',
				'code'		=> 404,
				'message'	=> "Image not found"
			);
			return response()->json($data, $data['code']);
		}
	}

	public function detail($id){
		$user = User::find($id);
		if (is_object($user)) {
			$detail = array(
				'status'	=> 'success',
				'code'		=> 200,
				'message'	=> "User found",
				'user'		=> $user
			);
		}else{
			$detail = array(
				'status'	=> 'error',
				'code'		=> 404,
				'message'	=> "User not found"
			);
		}
		return response()->json($detail, $detail['code']);
	}
}
