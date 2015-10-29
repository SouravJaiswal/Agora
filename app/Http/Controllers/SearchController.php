<?php

namespace Agora\Http\Controllers;

use DB;
use Agora\Models\User;
use Illuminate\Http\Request;

/**
* SearchController
*/
class SearchController extends Controller
{
	
	public function getSearchResults(Request $request)
	{
		$query = $request->input('query');

		if(!$query){
			return redirect()->route('home');
		}

		//What am I doing here??????

		$users = User::where(DB::raw("CONCAT(first_name, ' ',last_name)"),'LIKE',"%{$query}%")
					->orWhere('username','LIKE',"%{$query}%")->get();

		//dd($users);
		return view('search.results')->with('users',$users);
	}
}