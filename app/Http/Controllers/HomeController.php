<?php

namespace Agora\Http\Controllers;

/**
* HomeController
*/
class HomeController extends Controller
{
	
	public function index()
	{
		return view('home');
	}
}