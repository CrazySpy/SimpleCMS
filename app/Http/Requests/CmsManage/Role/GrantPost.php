<?php

namespace App\Http\Requests\CmsManage\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class GrantPost extends FormRequest
{
	const ROLE_ADMINISTRATOR = 1;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
	{
		$admin = Auth::user();
		$role = $admin->role;
		if($role->id == self::ROLE_ADMINISTRATOR) return true;
		$validNodeIds = [];
		$validNodes = $role->validNodes;
		foreach($validNodes as $validNode)
		{
			$validNodeIds[] = $validNode->id;
		}
		
		$grants = $this->input('grants');
		foreach($grants as $grant)
		{
			if(!in_array($grant, $validNodeIds))
			{
				return false;
			}
		}
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		return [
			'grants' => 'required|array'
        ];
    }
}
