<?php

namespace Agora\Http\Controllers;


use Auth;
use Agora\Models\User;
use Illuminate\Http\Request;

/**
* StatusController
*/
class StatusController extends Controller
{
	
	public function postUpdate(Request $request){

		$this->validate($request,[
			'status' => 'required|max:1000'
		]);

		Auth::user()->statuses()->create([
			'body' => $request->input('status'),
		]);

		return redirect()->route('home')->with('info','Status Posted.');

	}

}