<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = [];
    //Author relationship
    public function author(){
        return $this->belongsTo(User::class,'user_id');
    }
     //Post relationship
     public function post(){
        return $this->belongsTo(Post::class);
    }
}
