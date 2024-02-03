<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index(){
        return view('admin.posts.index',['posts'=> Post::paginate(50)]);
    }
    public function create(){
        return view('admin.posts.create',['categories'=> Category::all()]);
       }
    public function store(){
        // $path = $request->file('thumbnail')->store('thumbnails');
        // return 'Done: '.$path;
        $attributes = array_merge($this->validatePost(),[
            'thumbnail' => request()->file('thumbnail')->store('thumbnails'),
            'user_id' =>auth()->id()
        ]);
        Post::create($attributes);
        return redirect('/')->with('success','your post has been created successfully');
    }
    public function edit(Post $post){
        return view('admin.posts.edit',['post' => $post , 'categories' => Category::all()]);
    }
    public function update(Post $post){
        $attributes = $this->validatePost($post);
        $attributes['user_id'] = auth()->id();
        if($attributes['thumbnail'] ?? false){
        $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }
        $post->update($attributes);
        return back()->with('success','Post Updated Successfully');
    }
    public function destroy(Post $post){
        $post->delete();
        return back()->with('success','Post Deleted Successfully');
    }
    protected function validatePost(?Post $post = null):array
    {
        $post ??= new Post();
        return request()->validate([
            'title' => 'required',
            'excerpt' => 'required',
            'body' => 'required',
            'thumbnail' => $post->exists?['image']:['required','image'],
            'slug' => ['required', Rule::unique('posts')->ignore($post->id)],
            'category_id' => ['required',Rule::exists('categories','id')]
            ]);
    }
}
