<?php

namespace App\Http\Controllers\CmsManage;

use App\Models\CmsManage\Access;
use App\Models\CmsManage\Role;
use App\Models\CmsManage\Node;

use App\Http\Requests\CmsManage\Role\AddAndEditPost;
use App\Http\Requests\CmsManage\Role\GrantPost;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
	const ROLE_ADMINISTRATOR = 1;
	
	public function __construct()
	{
		$this->middleware('access');
	}

	public function list(Request $request)
	{
		$size = 20;
		$roles = Role::paginate($size);
		
		return view('CmsManage.Role.list', ['roles' => $roles]);
	}

	public function addShow()
	{
		return view('CmsManage.Role.edit', ['role' => [], 'action' => route('role.add.add')]);
	}

	public function add(AddAndEditPost $request)
	{
		$request->validated();

		$input = $request->only(['name', 'remark', 'status']);
		$isAddSuccess = Role::create([
			'name' => $input['name'],
			'remark' => $input['remark'],
			'status' => $input['status']
		]);

		if($isAddSuccess) return $this->success(200, '添加成功');
		return $this->error(201, '添加失败');
	}

	public function editShow(Role $role)
	{
		return view('CmsManage.Role.edit', ['role' => $role, 'action' => route('role.edit.edit', $role->id)]);
	}

	public function edit(AddAndEditPost $request, Role $role)
	{
		if($role->id == self::ROLE_ADMINISTRATOR) return $this->error(204, '超级管理员角色不可修改');
		$request->validated();

		$input = $request->only(['name', 'remark', 'status']);
		$isUpdateSuccess = $role->update([
			'name' => $input['name'],
			'remark' => $input['remark'],
			'status' => $input['status']
		]);
		
		if($isUpdateSuccess) return $this->success(200, '编辑成功');
		return $this->error(201, '编辑失败');
	}

	public function delete(Request $request)
	{
		$roleIds = $request->input('ids');

		if(!is_array($roleIds)) $roleIds = array($roleIds);

		$failed = [];
		foreach($roleIds as $roleId)
		{
			if($roleId == self::ROLE_ADMINISTRATOR) 
			{
				$failed[] = $roleId;
				continue;
			}
			$isDeleteSuccess = Role::where('id', '=', $roleId)->delete();
			if(!$isDeleteSuccess)
			{
				$failed[] = $roleId;
			}
			else
			{
				//Delete the access list.
				Access::where('Role_id', '=', $roleId)->delete();
			}
		}

		if(empty($failed)) return $this->success(200, '删除成功');
		return $this->error(201, 'id为' . implode(',', $failed) . '删除失败');
	}

	public function changeStatus($roleIds, $toStatus)
	{
		if(!is_array($roleIds)) $roleIds = array($roleIds);
		if($toStatus) $toStatus = 1;
		else $toStatus = 0;

		$failed = [];
		foreach($roleIds as $roleId)
		{
			if($roleId == self::ROLE_ADMINISTRATOR)
			{
				$failed[] = $roleId;
				continue;
			}
			
			$role = Role::find($roleId);
			if($role->status == $toStatus) continue;
			
			$isChangeSuccess = $role->update(['status' => $toStatus]);
			if(!$isChangeSuccess) $failed[] = $roleId;
		}

		if(empty($failed)) return $this->success(200, '修改成功');
		return $this->error(201,'id为' . implode(',', $failed) . '修改失败');
	}

	public function enable(Request $request)
	{
		$roleIds = $request->input('ids');
		return $this->changeStatus($roleIds, true);
	}

	public function disable(Request $request)
	{
		$roleIds = $request->input('ids');
		return $this->changeStatus($roleIds, false);
	}

	public function grantShow(Role $role)
	{
		$admin = Auth::user();
		$adminRole = $admin->role;

		$validNodes = [];
		if($adminRole->id == 1) 
		{
			$validNodes = Node::orderBy('sort')->get();
		}
		else 
		{
			$validNodes = $adminRole->validNodes()->orderBy('sort')->get();
		}

		$tree = [];
		$nodeDict = [];
		foreach($validNodes as $validNode)
		{
			$tree[$validNode['pid']][] = $validNode['id'];
			$nodeDict[$validNode['id']] = $validNode;
		}
		return view('CmsManage.Role.grant', ['nodeIdTree' => $tree, 'nodeDict' => $nodeDict, 'role' => $role]);
	}

	public function nodeGrant($nodeIds, Role $role)
	{
		foreach($nodeIds as $nodeId)
		{
			Access::create([
				'Role_id' => $role->id,
				'Node_id' => $nodeId
			]);
		}
	}

	public function nodeUngrant($nodeIds, Role $role)
	{
		foreach($nodeIds as $nodeId)
		{
			Access::where('Role_id', '=', $role->id)->where('Node_id', '=', $nodeId)->delete();
		}
	}
	
	public function grant(GrantPost $request, Role $role)
	{
		if($role->id == 1) return $this->error(204, '超级管理员角色不可修改授权');
		$request->validated();
		$grants = $request->input('grants');

		$admin = Auth::user();
		$adminRole = $admin->role;
		$validNodes = [];
		if($adminRole->id == self::ROLE_ADMINISTRATOR) 
		{
			$validNodes = Node::orderBy('sort')->get();
		}
		else 
		{
			$validNodes = $adminRole->validNodes()->orderBy('sort')->get();
		}

		$validNodeIds = [];
		foreach($validNodes as $validNode)
		{
			$validNodeIds[] = $validNode->id;
		}

		//Get current role's granted nodes' ids.
		$grantedNodes = $role->validNodes;
		$grantedNodeIds = [];
		foreach($grantedNodes as $grantedNode)
		{
			$grantedNodeIds[] = $grantedNode->id;
		}

		//Get new added nodes to be granted.
		$toGrant = [];
		foreach($grants as $grant)
		{
			if(in_array($grant, $grantedNodeIds)) continue;
			$toGrant[] = $grant;
		}

		//Nodes to be ungranted are those who is in logined user's valid nodes,
		//not the selected role's valid nodes.
		$toUnGrant = array_diff($validNodeIds, $grants);

		$this->nodeGrant($toGrant, $role);
		$this->nodeUngrant($toUnGrant, $role);

		return $this->success(200, '操作完成');
	}

}
