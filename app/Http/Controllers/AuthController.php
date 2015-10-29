<?php

namespace Agora\Http\Controllers;


use Illuminate\Http\Request;
use Agora\Models\User;
use Auth;

/**
* HomeController
*/
class AuthController extends Controller
{
	
	public function getSignup()
	{
		return view('auth.signup');
	}

	public function postSignup(Request $request){
			$this->validate($request,[
				'email'=>	'required|unique:users|email|max:255',
				'username' =>  'required|unique:users|alpha_dash|max:255', 
				'password' => 'required|min:6'
			]);

			User::create([
				'email'=>$request->input('email'),
				'username'=>$request->input('username'),
				'password' => bcrypt($request->input('password'))
			]);
			return redirect()->route('home')->with('info',"Your account has been created and you can now sign in");
	}
	public function getSignin()
	{
		return view('auth.signin');
	}

	public function postSignin(Request $request){
			$this->validate($request,[
				'email' =>  'required', 
				'password' => 'required'
			]);

			if (!Auth::attempt($request->only(['email','password']),$request->has('remember'))) {
				return redirect()->back()->with('info','Sorry :( We couldn\'t sign you in');
			}
			return redirect()->route('home')->with('info',"You have been signed in");
	}

	public function getSignOut(){
		
		Auth::logout();

		return redirect()->route('home')->with('info','You\'ve been logged out');
	}
}