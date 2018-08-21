<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class RegisterController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest');
	}

	public function index()
	{
		return view('auth.register');
	}

	public function validator(array $data)
	{
		return Validator::make($data,[
			'username' => 'required|string|max:255|unique:users',
			'password' => 'required|string|min:8|confirmed',
			'email' => 'required|string|max:255|unique:users'
		]);
	}
	
	public function create(Request $request)
	{
		$input = $request->only(['username','email','password']);
		$this->validator($input);
		return User::create([
			'username' => $input['username'],
			'email' => $input['email'],
			'password' => Hash::make($input['password'])
		]);
	}
}
