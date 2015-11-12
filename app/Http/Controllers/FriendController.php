<?php

namespace Agora\Http\Controllers;

use Auth;
use Agora\Models\User;
use Illuminate\Http\Request;

/**
* FriendController
*/
class FriendController extends Controller
{
	
	public function index(){

		$users = Auth::user()->friends();

		$friends = Auth::user()->friendsRequest();

		return view('friend.index')->with('users',$users)
								   ->with('friends',$friends);

	}

	public function getAdd($username){
		$user = User::where('username',$username)->first();

		if(!$user){
			return redirect()->route('home')->with('info','User not found'); 
		}

		if(Auth::user()->hasFriendRequestPending($user) || 
				 $user->hasFriendRequestPending(Auth::user())){
			return redirect()->route('profile.index',['username'=>$user->username])
							 ->with('info','Friend request already pending.');
		}

		if(Auth::user()->isFriendsWith($user)){
			return redirect()->route('profile.index',['username'=>$user->username])
							 ->with('info','You are already friends');
		}

		Auth::user()->addFriend($user);


		return redirect()->route('profile.index',['username'=>$username])
						->with('info','Friend request sent');
	}

	public function getAccept($username){
		$user = User::where('username',$username)->first();

		if(!$user){
			return redirect()->route('home')->with('info','User not found'); 
		}

		if(Auth::user()->id === $user->id){
			return redirect()->route('home');
		}

		if(!Auth::user()->hasFriendRequestRecieved($user)){
			return redirect()->route('home');
		}

		Auth::user()->acceptFriendRequest($user);

		return redirect()->route('profile.index',['username'=>$username])
						 ->with('info','Friend request accepted.');
	}
}












