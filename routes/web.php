<?php

use Illuminate\Support\Facades\Route;
use App\Post;
use App\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-orm', function () {
    $posts = Post::all();
    foreach($posts as $post){
        echo "<h1>{$post->title}</h1>";
        echo "<span style='color:gray;'>{$post->user->name} - {$post->category->name}</span>";
        echo "<p>{$post->content}</p>";
        echo "<hr>";
    }
});

//Api Route
Route::get('/user/test','UserController@test');
Route::get('/category/test','CategoryController@test');
Route::get('/post/test','PostController@test');

//User
Route::post('/api/register','UserController@register');
Route::post('/api/login','UserController@login');
Route::post('/api/user/update','UserController@update');
