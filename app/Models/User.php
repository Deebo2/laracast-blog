<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    //Set a Mutator for the password attribute
    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }
    //Set an Accessor for the username attribute
    public function getUsernameAttribute($username){
        return ucwords($username);
    }
    //Has Many Posts Relationship
    public function posts(){
        return $this->hasMany(Post::class);
    }
    //Has many comments
    public function comments(){
        return $this->hasMany(Comment::class);
    }

}
