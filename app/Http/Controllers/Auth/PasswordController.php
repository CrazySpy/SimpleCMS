<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
	public function __construct()
	{
		$this->middleware('guest');
	}

	public function sendEmail()
	{
	}
	
	public function inputEmail()
	{
		return view('auth.passwords.email');
	}
}
