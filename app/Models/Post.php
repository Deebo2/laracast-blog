<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title','excerpt','slug','body','category_id','user_id','thumbnail'];
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function scopeFilter($query, array $filters){
        $query->when($filters['category'] ?? false ,function($query,$category){
            $query->whereHas('category',function($query) use($category){
                $query->where('slug',$category);
            });
        });
        $query->when($filters['search'] ?? false ,function($query,$search){
            $query->where(function($query) use($search){
                $query->where('title','like','%'.$search.'%')
                ->orWhere('body','like','%'.$search.'%');
            });
        });
        $query->when($filters['author'] ?? false ,function($query,$username){
            $query->whereHas('author',function($query) use($username){
                $query->where('username',$username);
            });
        });

    }
}
//Post::create(['title'=>'my first post','excerpt'=>'my excerpt','slug'=>'my-first-post','body'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit.','category_id'=>1]);
