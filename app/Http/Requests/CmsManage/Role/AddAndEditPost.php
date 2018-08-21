<?php

namespace App\Http\Requests\CmsManage\Role;

use Illuminate\Foundation\Http\FormRequest;

class AddAndEditPost extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
			'name' => 'required|string|max:16',
			'remark' => 'nullable|string|max:255',
			'status' => 'required|integer',
        ];
    }
}
