<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class LoginController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	public function index()
	{
		return view('Auth.login');
	}

	public function validator(array $data)
	{
		return Validator::make($data,[
			'loginName' => 'required|string|max:255',
			'password' => 'required|string|max:255'
		]);
	}

	public function login(Request $request)
	{
		$request->flash();
		
		$input = $request->only(['loginName','password']);
		$this->validator($input);

		if(Auth::attempt(['username' => $input['loginName'], 'password' => $input['password'], 'status' => 1]))
		{
			return redirect('/index');
		}
		else if(strchr($input['loginName'],'@') != false)
		{
			if(Auth::attempt(['email' => $input['loginName'], 'password' => $input['password'], 'status' => 1]))
			{
				return redirect('/index');
			}
		}

		return redirect(route('login'));
	}

	public function logout()
	{
		Auth::logout();
		return redirect(route('login'));
	}
}
