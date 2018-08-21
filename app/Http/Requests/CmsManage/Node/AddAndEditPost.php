<?php

namespace App\Http\Requests\CmsManage\Node;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\CmsManage\Role;
use App\Services\CmsManage\Admin as AdminService;

class AddAndEditPost extends FormRequest
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
		if($admin->Role_id == self::ROLE_ADMINISTRATOR) return true;

		$pid = $this->input('pid');
		$isPidValid = true;
		if($pid != 0) $isPidValid = AdminService::hasAccess($pid);

		$id = $this->input('id');
		$isIdValid = true;
		if(!empty($id)) $isIdValid = AdminService::hasAccess($id);

		return $isPidValid && $isIdValid;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'id' => 'nullable|integer',
			'name' => 'required|string|max:16',
			'uri' => 'nullable|string|max:255',
			'accessTag' => 'nullable|string|max:128',
			'sort' => 'required|integer:255',
			'pid' => 'required|integer',
			'remark' => 'nullable|string|max:255',
			'status' => 'required|integer'
		];
	}
}

