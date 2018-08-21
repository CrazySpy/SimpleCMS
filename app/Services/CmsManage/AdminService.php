<?php

namespace App\Services\CmsManage;

use App\Models\CmsManage\Admin;
use App\Models\CmsManage\Node;

use App\Services\CmsManage\RoleService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminService
{
	const ROLE_ADMINISTRATOR = 1;
	/**
	 * Check if the user has access to the given node.
	 * 
	 * @param NodeModel|String|Integer		 $node
	 * @param AdminModel|String|Integer|null $admin
	 * @return Boolean
	 */
	public static function hasAccess($node, $admin=null)
	{
		if(empty($admin)) $admin = Auth::user();

		$role;
		if($admin instanceof Admin)
		{
			$role = $admin->Role_id;
		}
		else
		{
			$admin = Admin::find($admin);
			if(empty($admin)) return false;
			$role = $admin[0]->Role_id;
		}

		if($node instanceof Node)
		{
			$node = $node->id;
		}
		
		if($role == self::ROLE_ADMINISTRATOR) return true;
		return RoleService::hasAccess($node, $role);
	}

	public static function getAvatar($adminId)
	{
		$isAvatarExists = Storage::exists('avatar/' . $adminId);
		$avatar = 'avatar/default';
		if($isAvatarExists)
		{
			$avatar = 'avatar/' . $adminId;
		}
		return $avatar;
	}

	public static function setAvatar($adminId, $file)
	{
		$isSaveSuccess = Storage::putFileAs('avatar', $file, $adminId);
		if(false === $isSaveSuccess) return false;
		return true;
	}
}

?>
