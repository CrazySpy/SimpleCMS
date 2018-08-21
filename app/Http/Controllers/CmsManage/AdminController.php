<?php

namespace App\Http\Controllers\CmsManage;

use App\Models\CmsManage\Admin;
use App\Models\CmsManage\Node;
use App\Models\CmsManage\Role;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Requests\CmsManage\Admin\AddPost;
use App\Http\Requests\CmsManage\Admin\EditPost;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use App\Services\CmsManage\AdminService;

class AdminController extends Controller
{
	//For edit user self's profile.
	public $accessIgnore = ['editShow', 'edit', 'getAvatar', 'setAvatar'];

	public function __construct()
	{
		$this->middleware('access');
	}

	/*
	 * This method is for methods which can't use IfHasMiddleware to check the access.
	 * Sometimes, the method is for both only the current user and all users.
	 * So it's hard to use IfHasMiddleware to check the access.
	 * And I call the type of access UNSTABLE ACCESS.
	 */
	private function checkUnstableAccess(Admin $admin)
	{
		if($admin->id != Auth::id()) 
		{
			$class = explode('\\', __CLASS__);
			$class = $class[count($class) - 1];
			$method = __FUNCTION__;
			
			$node = Node::where('accessTag', '=', $class . '@' . $method)->get();
			if($node->isEmpty())
			{
				$node = Node::where('accessTag', '=', $class)->get();
			}
			
			if($node->isEmpty())
			{
				return false;
			}
			$node = $node[0];

			if(!AdminService::hasAccess($node))
			{
				return false;
			}
		}
		return true;
	}

	public function addShow()
	{
		$validRoles = Role::all();
		
		return view('CmsManage.Admin.add', ['admin' => [], 'validRoles' => $validRoles, 'action' => route('admin.add.add')]);
	}

	public function add(AddPost $request)
	{
		$request->validated();

		$input = $request->only(['username', 'password', 'email', 'role', 'status']);
		$isAddSuccess = Admin::create([
			'username' => $input['username'],
			'password' => Hash::make($input['password']),
			'email' => $input['email'],
			'Role_id' => $input['role'],
			'status' => $input['status']
		]);
		if($isAddSuccess) return $this->success(200, '添加成功');
		return $this->error(201,'添加失败');
	}

	public function editShow(Admin $admin)
	{
		if(!$this->checkUnstableAccess($admin)) return $this->error(202, '未授权访问');
		
		$validRoles = Role::all();
		
		return view('CmsManage.Admin.edit', ['admin' => $admin, 'validRoles' => $validRoles, 'action' => route('admin.edit.edit', $admin->id)]);
	}

	public function edit(EditPost $request, Admin $admin)
	{
		if(!$this->checkUnstableAccess($admin)) return $this->error(202, '未授权访问');		
		if($admin->id != $request->input('id')) return $this->error(202, '未授权访问');
		
		$request->validated();
		
		$input = $request->only(['id', 'username', 'password', 'email', 'role', 'status']);
		$updateArray = [
			'username' => $input['username'],
			'email' => $input['email'],
			'Role_id' => $admin->id == 1 ? 1 : $input['role'], //Super admin must be super admin role.
			'status' => $input['status']
		];

		if(isset($input['password']) && $input['password'])
		{
			$updateArray['password'] = Hash::make($input['password']);
		}
		$isUpdateSuccess = $admin->update($updateArray);
		
		if($isUpdateSuccess) return $this->success(200, '修改成功');
		return $this->error(201,'修改失败');
	}

	
	public function list()
	{
		$size = 20;

		$admins = Admin::paginate($size);
		foreach($admins as $key =>$admin)
		{
			if(isset($admin->role) && !empty($admin->role))
			{
				$admins[$key]['role'] = $admin->role->name;
			}
			else
			{
				$admins[$key]['role'] = '无';
			}
		}
		return view('CmsManage.Admin.list', ['admins' => $admins]);
	}

	public function changeStatus($adminIds, $toStatus)
	{
		if(!is_array($adminIds)) $adminIds = array($adminIds);
		if($toStatus) $toStatus = 1;
		else $toStatus = 0;

		$failed = [];
		foreach($adminIds as $adminId)
		{
			//Superadmin
			if($adminId == 1) return $this->error(204, '超级管理员不可修改');

			$admin = Admin::find($adminId);
			if($admin->status == $toStatus) continue;
			
			$isChangeSuccess = $admin->update(['status' => $toStatus]);
			if(!$isChangeSuccess) $failed[] = $adminId;
		}

		if(empty($failed)) return $this->success(200, '修改成功');
		return $this->error(201,'id为' . implode(',', $failed) . '修改失败');
	}

	public function enable(Request $request)
	{
		$adminIds = $request->input('ids');
		return $this->changeStatus($adminIds, true);
	}

	public function disable(Request $request)
	{
		$adminIds = $request->input('ids');
		return $this->changeStatus($adminIds, false);
	}

	public function delete(Request $request)
	{
		$adminIds = $request->input('ids');
		if(!is_array($adminIds)) $adminIds = array($adminIds);

		$failed = [];
		foreach($adminIds as $adminId)
		{
			//Superadmin
			if($adminId == 1) return $this->error(204, '超级管理员不可修改');

			//Delete user self is not allowed.
			if($adminId == Auth::id())
			{
				$failed[] = $adminId;
				continue;
			}
			$isDeleteSuccess = Admin::where('id', '=', $adminId)->delete();
			if(!$isDeleteSuccess) $failed[] = $adminId;
		}

		if(empty($failed)) return $this->success(200, '删除成功');
		return $this->error(201,'id为' . implode(',', $failed . '删除失败'));
	}

	public function setAvatar(Request $request, Admin $admin)
	{
		if(!$this->checkUnstableAccess($admin)) return $this->error(202, '未授权访问');
		
		if(!$request->hasFile('avatar')) return $this->error(205, '图片为空');
		$avatar = $request->file('avatar');
		$availableType = ['jpeg', 'jpg', 'png', 'gif'];
		if(!in_array($avatar->extension(), $availableType)) return $this->error(202, '上传头像必须为jpg格式');

		$isStoreSuccess = AdminService::setAvatar($admin->id, $avatar);
		if($isStoreSuccess) return $this->success(200, '设置成功');
		return $this->error(201, '设置失败');
	}

	public function getAvatar(Admin $admin)
	{
		if(!$this->checkUnstableAccess($admin)) return $this->error(202, '未授权访问');
		
		$adminId = $admin->id;

		$avatarPath = AdminService::getAvatar($adminId);
		$availableType = ['image/jpeg', 'image/png', 'image/gif'];
		$avatarMimeType = Storage::getMimetype($avatarPath);
		if(in_array($avatarMimeType, $availableType)) return response(Storage::get($avatarPath))->header('Content-Type', $avatarMimeType);
		return response('')->header('Content-Type', 'image/jpeg');
	}

}
