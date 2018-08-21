<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Models\CmsManage\Node;
use App\Models\CmsManage\Access;

use App\Services\CmsManage\RoleService;

class IfHasAccess
{
	const ROLE_ADMINISTRATOR = 1;
	
	/*
	 * Get the name of the controller and method.
	 * @param \Illuminate\Http\Request $request
	 * @return mixed
	 */
	private function getActionDetail($request)
	{
		$action = Route::current()->getActionName();
		if($action == 'Closure')
		{
			return ['controller' => $action];
		}
		
		list($class, $method) = explode('@', $action);
		
		$part = explode('\\', $class);
		return ['controller' => $part[count($part) - 1], 'method' => $method];
	}
	
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
	{
		$actionDetail = $this->getActionDetail($request);
		$controllerName = $actionDetail['controller'];
		//Admit closure's access
		if($controllerName == 'Closure') return $next($request);

		//Admit the method in ignore list.
		$method = $actionDetail['method'];
		$ignoreList = $request->route()->getController()->accessIgnore;
		if(in_array($method, $ignoreList)) return $next($request);

		$admin = Auth::user();
		$role = $admin->role;
		//If the user's role id is 0, then forbidden it.
		if(empty($role) || $role->status == 0) return redirect(route('error'));
		//If the user's role id is 1, then give the access.
		if($role->id == self::ROLE_ADMINISTRATOR) return $next($request);

		//Check if the role has the access of the node which specified the method.
		$withMethodNodes = Node::where('accessTag', '=', $controllerName . '@' . $method)->where('status', '=', '1')->get();
		if(isset($withMethodNodes[0]) && $withMethodNodes[0])
		{
			$hasAccess = RoleService::hasAccess($withMethodNodes[0], $role);
			if($hasAccess)
			{
				return $next($request);
			}
			return redirect(route('error'));
		}

		//Check the access by controller name without method name.
		$validNodes = $role->validNodes;
		if(empty($validNodes)) return redirect(route('error'));
		foreach($validNodes as $validNode)
		{
			if($validNode->accessTag == $controllerName && $validNode->status == 1)
			{
				return $next($request);
			}
		}

		return redirect(route('error'));
	}
}
