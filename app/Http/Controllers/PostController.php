<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;

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
}
