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
}