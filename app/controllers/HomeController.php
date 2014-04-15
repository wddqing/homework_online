<?php

use Illuminate\Support\Facades\Auth;
class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	//首页
	public function mainPage()
	{
		$result['email'] = null;
		$result['id'] = null;
		if(Auth::check()){
			$result['email'] = Auth::user()->email;
			$result['id'] = Auth::user()->id;
		}
		
		
		return View::make('home.hello',$result);
	}
	
	public function showRoute()
	{
		if(Auth::check()){
			return Auth::user()->email;
		}else{
			return "not login";
		}
		
	}

}