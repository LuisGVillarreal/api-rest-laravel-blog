<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use App\Helpers\JwtAuth;

class PostController extends Controller{

	function __construct(){
		$this->middleware('api.auth', ['except' => [
			'index', 
			'show', 
			'getImage',
			'getPostsByCategory',
			'getPostsByUser'
		]]);
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
		$json = $request->input('json', null);
		$params_array = json_decode($json, true);

		if (!empty($params_array)) {
			//Get auth user
			$user = $this->getIdentity($request);

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
				unset($params_array['updated_at']);
				unset($params_array['user']);
				unset($params_array['category']);

				//Get auth user
				$user = $this->getIdentity($request);
				$post = Post::where(['id' => $id, 'user_id' => $user->sub])->update($params_array);
				$update = [
					'status'   => $post ? "Success" : "Error",
					'code'     => $post ? 200 : 400,
					'message'  => $post ? "Post updated successfully" : "Failed to update post"
				];
			}
		} else {
			$update = [
				'status'	=> "Error",
				'code'		=> 400,
				'message'	=> 'Error to update'
			];
		}
		return response()->json($update, $update['code']);
	}

	//Delete a post
	public function destroy($id, Request $request){
		//Get auth user
		$user = $this->getIdentity($request);
		$post = Post::where('id', $id)
					->where('user_id', $user->sub)
					->first();
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
				'message'	=> 'Error to delete'
			];
		}
		return response()->json($delete, $delete['code']);
	}

	private function getIdentity($request){
		$jwtAuth = new JwtAuth();
		$token = $request->header('Authorization', null);
		$user = $jwtAuth->checkToken($token, true);
		return $user;
	}

	//Upload image
	public function upload(Request $request){
		$image = $request->file('file0');
		$validate = \Validator::make($request->all(), [
			'file0'	=> 'required|image|mimes:jpg,jpeg,png,gif'
		]);
		if ($image && !$validate->fails()) {
			$image_name = time().$image->getClientOriginalName();
			\Storage::disk('images')->put($image_name, \File::get($image));
			$data = [
				'status'	=> 'succes',
				'code'		=> 200,
				'image'		=> $image_name
			];
		}else{
			$data = [
				'status'	=> 'error',
				'code'		=> 400,
				'message'	=> "Uploaded data error"
			];
		}
		return response()->json($data, $data['code']);
	}

	//Get a image
	public function getImage($filename){
		$isset = \Storage::disk('images')->exists($filename);
		if ($isset) {
			$file = \Storage::disk('images')->get($filename);
			$file_mime = \File::mimeType(\Storage::disk('images')->path($filename));
	        return response()->make($file, 200, [
	            'Content-Type' => $file_mime,
	            'Content-Disposition' => 'inline; filename="'.$filename.'"'
	        ]);
		}else{
			$data = [
				'status'	=> 'error',
				'code'		=> 404,
				'message'	=> "Image not found"
			];
			return response()->json($data, $data['code']);
		}
	}

	//Get posts by category
	public function getPostsByCategory($id){
		$posts = Post::where('category_id', $id)->get();

		return response()->json([
			'status'	=> 'Success',
			'posts'	=> $posts
		], 200);
	}

	//Get posts by user
	public function getPostsByUser($id){
		$posts = Post::where('user_id', $id)->get();

		return response()->json([
			'status'	=> 'Success',
			'posts'	=> $posts
		], 200);
	}
}
