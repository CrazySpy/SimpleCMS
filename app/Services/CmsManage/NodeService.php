<?php

namespace App\Services\CmsManage;

use App\Models\CmsManage\Role;
use App\Models\CmsManage\Node;
use App\Models\CmsManage\Access;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NodeService
{
	const ROLE_ADMINISTRATOR = 1;
	
	private function nodeExpression($nodeIdTree, $children, $dict, $vis)
	{
		$str = '';
		foreach($children as  $child)
		{
			//Determin if the node has been shown.
			//If A node is the child of the B node, 
			//and B node is also the child of A node, 
			//the situation will cause the problem.
			if(in_array($child, $vis)) continue;
			$vis[] = $child;

			if(isset($nodeIdTree[$child]))
			{
				$str .= '<li class="treeview">';
				$str .= '<a href="' . (isset($dict[$child]->url) && $dict[$child]->url ? $dict[$child]->uri : '#') . '">' . 
					'<i class="fa fa-share"></i> <span>' . $dict[$child]->name . '</span>' .
					'<span class="pull-right-container">' .
					'<i class="fa fa-angle-left pull-right"></i>' .
					'</span>' .
					'</a>';

				$str .= '<ul class="treeview-menu">';
				$str .= $this->nodeExpression($nodeIdTree, $nodeIdTree[$child], $dict, $vis);
				$str .= '</ul>';
				$str .= '</li>';
			}
			else
			{
				$str .= '<li>' . 
					'<a class="treeview-href content-link" href="' . $dict[$child]->uri . '">' .
					'<i class="fa fa-circle-o"></i>' .
					$dict[$child]->name .
					'</a>' .
					'</li>';
			}						
		}
		return $str;
	}

	public function getSidebarTree()
	{
		$role = Auth::user()->role;
		if(empty($role) || $role->status == 0) return null;
		$validNodes = [];
		//role 0 indicates that the user is a guest
		if($role->id == self::ROLE_ADMINISTRATOR) 
		{
			$validNodes = Node::where('status', '=', '1')->orderBy('sort')->get();
		}
		else if($role)
		{
			$validNodes = $role->validNodes()->where('status', '=', '1')->orderBy('sort')->get();
		}

		$nodeIdTree = [];
		$nodeDict = [];
		foreach($validNodes as $validNode)
		{
			$nodeIdTree[$validNode->pid][] = $validNode->id;
			$nodeDict[$validNode->id] = $validNode;
		}

		if(!isset($nodeIdTree['0']) || empty($nodeIdTree['0'])) return ;

		return $this->nodeExpression($nodeIdTree,$nodeIdTree['0'], $nodeDict, []);
	}
}

?>

