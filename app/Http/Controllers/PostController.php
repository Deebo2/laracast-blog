<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
   public function index(){
    $posts = Post::latest()->filter(request()->all())->paginate(6)->withQueryString();
    return view('posts.index',['posts' => $posts]);
   }
   public function show(Post $post){
    DB::listen(function($query){
        logger($query->sql,$query->bindings);
    });
    return view('posts.show',['post'=>$post->load('comments')]);
   }
  
}
