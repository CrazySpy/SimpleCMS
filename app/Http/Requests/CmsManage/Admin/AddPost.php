<?php

namespace App\Http\Requests\CmsManage\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddPost extends FormRequest
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
			'username' => 'required|unique:Admin,username|string|max:16',
			'password' => 'required|confirmed',
			'email' => 'nullable|email',
			'role' =>'required|int' ,
			'status' => 'required|int'
        ];
    }
}
