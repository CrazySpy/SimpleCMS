<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Services\CmsManage\AdminService;

class AvatarController extends Controller
{
	public function getAvatar(Request $request)
	{
		$admin = Auth::user();

		$avatarPath = AdminService::getAvatar($admin->id);
		$availableType = ['image/jpeg', 'image/png', 'image/gif'];
		$avatarMimeType = Storage::getMimetype($avatarPath);
		if(in_array($avatarMimeType, $availableType)) return response(Storage::get($avatarPath))->header('Content-Type', $avatarMimeType);
		return response('')->header('Content-Type', 'image/jpeg');

		return response(Storage::get($avatar))->header('Content-Type', 'image/jpeg');
	}

}
