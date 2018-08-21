<?php

namespace App\Models\CmsManage;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $table = 'Role';
	public $fillable = ['name', 'remark', 'status'];
	public $timestamps = false;

	public function admins()
	{
		return $this->hasMany('App\Models\CmsManage\Admin');
	}

	public function validNodes()
	{
		return $this->belongsToMany('App\Models\CmsManage\Node', 'Access', 'Role_id', 'Node_id');
	}

}
