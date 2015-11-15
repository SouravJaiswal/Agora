<?php

namespace Agora\Http\Controllers;

use Auth;
use Agora\Models\User;
use Illuminate\Http\Request;

/**
* ProfileController
*/
class ProfileController extends Controller
{
	
	public function getProfile($username)
	{
		$user = User::where('username',$username)->first();


		if(!$user){
			abort(404);
		}

		$statuses = $user->statuses()->notReply()->paginate(10);
		return view('profile.index')
				->with('user',$user)
				->with('statuses',$statuses)
				->with('authUserIsFriend',Auth::user()->isFriendsWith($user));
	}

	public function getEdit()
	{
		return view('profile.edit');
	}

	public function postEdit(Request $request)
	{
		$this->validate($request,[
			'first_name' =>'alpha|max:60',
			'last_name' =>'alpha|max:60',
			'location' =>'max:20',
		]);

		Auth::user()->update([
			'first_name' =>$request->input('first_name'),
			'last_name' =>$request->input('last_name'),
			'location' =>$request->input('location'),
		]);

		return redirect()->route('profile.edit')->with('info','Your profile has been updated');
	}
	
}