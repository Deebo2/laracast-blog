<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    //Get login page
    public function create(){
        return view('session.create');
    }
    //Login User
    public function store(Request $request){
        $attributes = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        //Attempt to validate and login the user based on the given credentials
        if(auth()->attempt($attributes)){
            session()->regenerate();
            return redirect('/')->with('success','Welcome Back !');
        }
        return back()->withInput()->withErrors(['login'=>'Your provided credentials could not be verfied']);
    }
    //Logout User
    public function destroy(){
        auth()->logout();
        return redirect('/')->with('success','Goodbye!');
    }
}
