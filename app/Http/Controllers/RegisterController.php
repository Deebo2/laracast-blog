<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    //Get Register page
    public function create(){
        return view('register.create');
    }
    public function store(Request $request){
    //Validate the request
    $attributes = $request->validate([
        'name' => 'required',
        'username' => ['required',Rule::unique('users')],
        'email' => 'required|email|unique:users,email',
        'password' => 'required'
    ]);
    //After validation successfully create the user
    $user = User::create($attributes);
    //login the uers
    auth()->login($user);
    //Redirect to the home page with success message
    return redirect('/')->with('success','Your account has been created successfully.');
   }
}
