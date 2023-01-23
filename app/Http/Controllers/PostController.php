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
				'category_id' 	=> 'required|numeric',
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

	//Update a post
	public function update($id, Request $request){
		$json = $request->input('json', null);
		$params_array = json_decode($json, true);

		if (!empty($params_array)) {
			$validate = \Validator::make($params_array, [
				"title" 		=> "required",
				"content"		=> "required",
				"category_id"	=> "required|numeric",
			]);
			if ($validate->fails()) {
				$update = [
					'status'	=> "Error",
					'code'		=> 400,
					'message'	=> $validate->errors()
				];
			} else {
				unset($params_array['id']);
				unset($params_array['user_id']);
				unset($params_array['created_at']);
				unset($params_array['user']);

				$post = Post::where('id', $id)->update($params_array);
				$update = [
					'status'	=> "Success",
					'code'		=> 200,
					'changes'		=> $params_array
				];
			}
			
		} else {
			$update = [
				'status'	=> "Error",
				'code'		=> 400,
				'message'	=> 'Error to send data'
			];
		}
		return response()->json($update, $update['code']);
	}

	//Delete a post
	public function destroy($id, Request $request){
		$post = Post::find($id);
		if (!empty($post)) {
			$post->delete();
			$delete = [
				'status'	=> "Success",
				'code'		=> 200,
				'message'	=> 'Post deleted'
			];
		} else {
			$delete = [
				'status'	=> "Error",
				'code'		=> 404,
				'message'	=> 'Post not found'
			];
		}
		return response()->json($delete, $delete['code']);
	}
}
