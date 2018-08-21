<?php

namespace App\Models\CmsManage;


use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
	use Notifiable;
	protected $table = 'Admin';
	const CREATED_AT = 'createTime';
	const UPDATED_AT = 'updateTime';

	protected $fillable = [
		'username', 'email', 'password', 'Role_id', 'status',
	];
	
	protected $hidden = ['password', 'remember_token'];

	public function role()
	{
		return $this->belongsTo('App\Models\CmsManage\Role', 'Role_id');
	}

}
