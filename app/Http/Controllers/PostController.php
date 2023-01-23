<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use App\Helpers\JwtAuth;

class PostController extends Controller{

	function __construct(){
		$this->middleware('api.auth', ['except' => ['index', 'show']]);
	}

	//Get all posts
	public function index(){
		$posts = Post::all()->load('category', 'user');
		return response()->json([
			'status'		=> "success",
			'code'			=> 200,
			'posts'			=> $posts
		], 200);
	}

	//Get a post
	public function show($id){
		$post = Post::find($id)->load('category', 'user');
		if (is_object($post)) {
			$post = [
				'status'		=> "success",
				'code'			=> 200,
				'post'			=> $post
			];
		} else {
			$post = [
				'status'		=> "Error",
				'code'			=> 404,
				'message'		=> "Post is not found",
			];
		}
		return response()->json($post, $post['code']);
	}

	//Save a post
	public function store(Request $request){
		$json = $request->input('json',null);
		$params_array = json_decode($json, true);

		if (!empty($params_array)) {
			$jwtAuth = new JwtAuth();
			$token = $request->header('Authorization', null);
			$user = $jwtAuth->checkToken($token, true);

			$validate = \Validator::make($params_array, [
				'title' 		=> 'required',
				'content' 		=> 'required',
				'category_id' 	=> 'required',
				'image'			=> 'required'

			]);

			if ($validate->fails()) {
				$store = [
					'status'	=> "Error",
					'code'		=> 400,
					'message'	=> $validate->errors()
				];
			} else {
				$post = new Post();
				$post->user_id 		= $user->sub;
				$post->category_id 	= $params_array['category_id'];
				$post->title 		= $params_array['title'];
				$post->content		= $params_array['content'];
				$post->image		= $params_array['image'];
				$post->save();

				$store = [
					'status'	=> "Success",
					'code'		=> 200,
					'post'		=> $post
				];
			}
			
		} else {
			$store = [
				'status'	=> "Error",
				'code'		=> 400,
				'message'	=> 'Error to send data'
			];
		}

		return response()->json($store, $store['code']);
	}
}
