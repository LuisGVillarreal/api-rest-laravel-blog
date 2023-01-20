<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;

/**
 * Search if the user exists with his credentials
 * Verify user data
 * Generate toke with authenticated user data
 * Return decoded data or token, from a parameter
 */
class JwtAuth{

	public $key;

	function __construct(){
		$this->key = 'Esto_es_una_clave_super_secrete-12e3456789';
	}

	public function signup($email, $password, $getToken = null){
		$credentials = ['email' => $email, 'password' => $password];
		if (\Auth::attempt($credentials)) {
			// Authentication passed...
			$user = \Auth::user();
			$token = array(
				'sub'		=> $user->id ,
				'email'		=> $user->email,
				'name'		=> $user->name,
				'surname'	=> $user->surname,
				'iat' 		=> time(),
				'exp' 		=> time() + (7 *24 * 60 * 60)
			);
			$jwt = JWT::encode($token, $this->key, 'HS256');
			$decoded = JWT::decode($jwt, $this->key, ['HS256']);
			$data = [
				'status' => 'success',
				'code' => 200,
				'message' => "Authenticated user",
				is_null($getToken) ? 'jwt' : 'decoded' => is_null($getToken) ? $jwt : $decoded
			];
		}else{
			$data = array(
				'status'	=> 'error',
				'code'		=> 401,
				'message'	=> "Error Login"
			);
		}
		return $data;
	}
}
