<?php

namespace App\Models\CmsManage;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
	protected $table = 'Node';
	public $timestamps = false;

	protected $fillable = ['name', 'accessTag', 'pid', 'uri', 'sort', 'status', 'remark'];

	public function parentNode()
	{
		return $this->belongsTo('App\Models\CmsManage\Node','pid');
	}
}
