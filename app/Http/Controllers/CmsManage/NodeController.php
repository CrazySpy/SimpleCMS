<?php

namespace App\Http\Controllers\CmsManage;

use App\Models\CmsManage\Role;
use App\Models\CmsManage\Node;
use App\Models\CmsManage\Access;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\CmsManage\Node\AddAndEditPost;

use App\Services\CmsManage\AdminService;

class NodeController extends Controller
{
	public function __construct()
	{
		$this->middleware('access');
	}
	
	public function addShow()
	{
		$admin = Auth::user();
		$role = Role::find($admin->Role_id);
		$validNodes = [];
		if(!empty($role)) $validNodes = $role->validNodes;

		return view('CmsManage.Node.edit', ['validNodes' => $validNodes, 'action' => route('node.add.add')]);
	}

	public function add(AddAndEditPost $request)
	{
		$input = $request->validated();

		$newNodeId = Node::insertGetId([
			'name' => $input['name'],
			'uri' => $input['uri'],
			'accessTag' => $input['accessTag'],
			'sort' => $input['sort'],
			'pid' => $input['pid'],
			'remark' => $input['remark'],
			'status' => $input['status']
		]);

		$admin = Auth::user();
		if(!empty($newNodeId) && $newNodeId > 0)
		{
			$isGrantSuccess = Access::create([
				'Role_id' => $admin->Role_id,
				'Node_id' => $newNodeId,
			]);
			if($isGrantSuccess) return $this->success(200, '添加成功');
		}
		return $this->error(201, '添加失败');
	}


	public function editShow(Node $node)
	{
		$admin = Auth::user();
		$role = Role::find($admin->Role_id);
		$validNodes = $role->validNodes;

		return view('CmsManage.Node.edit', ['node' => $node, 'validNodes' => $validNodes, 'action' => route('node.edit.edit', $node->id)]);
	}

	public function edit(AddAndEditPost $request, Node $node)
	{
		$input = $request->validated();

		$isEditSuccess = $node->update([
			'name' => $input['name'],
			'uri' => $input['uri'],
			'accessTag' => $input['accessTag'],
			'sort' => $input['sort'],
			'pid' => $input['pid'],
			'remark' => $input['remark'],
			'status' => $input['status']
		]);

		if($isEditSuccess) return $this->success(200, '编辑成功');
		return $this->error(201, '编辑失败');
	}

	public function list(Request $request)
	{
		$size = 20;
		$nodes = Node::with('parentNode')->paginate($size);

		return view('CmsManage.Node.list',['nodes' => $nodes]);
	}

	public function delete(Request $request)
	{
		$nodeIds = $request->input('ids');
		if(!is_array($nodeIds)) $nodeIds = array($nodeIds);

		$failed = [];
		foreach($nodeIds as $nodeId)
		{
			$access = AdminService::hasAccess($nodeId, Auth::user());
			if(!$access) 
			{
				$failed[] = $nodeId;
				continue;
			}

			$isDeleteSuccess = Node::where('id', '=', $nodeId)->delete();
			if(!$isDeleteSuccess)
			{
				$failed[] = $nodeId;
			}
		}
		
		if(!empty($failed)) return $this->error(201,'id为' . implode(',', $failed) . '删除失败');
		return $this->success(200, '删除成功');
	}

	public function changeStatus($nodeIds, bool $toStatus)
	{
		if(!is_array($nodeIds)) $nodeIds = array($nodeIds);
		if($toStatus) $toStatus = 1;
		else $toStatus = 0;

		$failed = [];
		foreach($nodeIds as $nodeId)
		{
			$access = AdminService::hasAccess($nodeId);
			if(!$access)
			{
				return 'access';
				$failed[] = $nodeId;
				continue;
			}

			$node = Node::find($nodeId);
			if($node->status == $toStatus) continue;
			
			$isChangeSuccess = $node->update(['status' => $toStatus]);
			if(!$isChangeSuccess) $failed[] = $nodeId;
		}

		if(!empty($failed)) return $this->error(201,'id为' . implode(',', $failed) . '修改失败');
		return $this->success(200, '修改成功');
	}

	public function enable(Request $request)
	{
		$nodeIds = $request->input('ids');
		return $this->changeStatus($nodeIds, true);
	}

	public function disable(Request $request)
	{
		$nodeIds = $request->input('ids');
		return $this->changeStatus($nodeIds, false);
	}

}
