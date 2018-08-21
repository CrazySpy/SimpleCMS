<?php

namespace App\Http\Requests\CmsManage\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditPost extends FormRequest
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
			'id' => 'required|integer',
			'username' => [
				'required',
				Rule::unique('Admin')->ignore($this->input('id')),
				'string',
				'max:16'
			],
			'password' => 'nullable|confirmed',
			'email' => 'nullable|email',
			'role' =>'required|int' ,
			'status' => 'required|int'
        ];
    }
}
