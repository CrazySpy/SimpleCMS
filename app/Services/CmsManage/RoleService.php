<?php

namespace App\Services\CmsManage;

use App\Models\CmsManage\Role;
use App\Models\CmsManage\Node;
use App\Models\CmsManage\Access;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleService
{
	const ROLE_ADMINISTRATOR = 1;
	
	/**
	 * Check if the role has access to the given node.
	 * 
	 * @param Node|String|Integer		$node
	 * @param Role|String|Integer|null $role
	 * @return Boolean
	 */
	public static function hasAccess($node, $role = null)
	{
		if(empty($role)) $role = Auth::user()->role;

		if($role instanceof Role)
		{
			$role = $role->id;
		}

		if($node instanceof Node)
		{
			$node = $node->id;
		}
		//Super admin role is supreme.
		if($node == self::ROLE_ADMINISTRATOR) return true;

		//If node is invalid, the users of the role has no access to any nodes.
		$nodeStatus = Node::find($node)->status;
		if($nodeStatus == 0) return false;
		$access = Access::where('Role_id', $role)->where('Node_id', $node)->get();

		if(!empty($access)) return true;
		return false;
	}

	private function nodeExpression($nodeIdTree, $children, $dict, $grantedNodeIds, $vis)
	{
		$str = '<div style="padding-left: 25px;">';

		foreach($children as  $child)
		{
			//Determin if the node has been shown.
			//If A node is the child of the B node, 
			//and B node is also the child of A node, 
			//the situation will cause the problem.
			if(in_array($child, $vis)) continue;

			$checked = false;
			if(in_array($child, $grantedNodeIds)) $checked = true;

			$str .= '<div style="margin-top: 10px;">' .
				'<input type="checkbox" name="grants[]" value="' . $child . '" ' . ($checked ? 'checked' : '') . '>' .
				'<span>' . $dict[$child]->name . '</span>';

			$vis[] = $child;
			if(isset($nodeIdTree[$child]))
			{
				$str .= $this->nodeExpression($nodeIdTree, $nodeIdTree[$child], $dict, $grantedNodeIds, $vis);
			}
		}
		$str .= '</div>';

		$str .= '</div>';
		return $str;
	}

	public function getGrantNodeTree($nodeIdTree, $nodeDict, $role)
	{
		if(!($role instanceof Role)) $role = Role::find($role);
		$validNodes = $role->validNodes;

		$grantedNodeIds = [];
		foreach($validNodes as $validNode)
		{
			$grantedNodeIds[] = $validNode->id;
		}

		return $this->nodeExpression($nodeIdTree, $nodeIdTree['0'], $nodeDict, $grantedNodeIds, []);
	}
}

?>
