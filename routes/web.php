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
