<?php

namespace App\Models\CmsManage;

use Illuminate\Database\Eloquent\Model;

class Access extends Model
{
	protected $table = 'Access';

	public $timestamps = false;

	protected $fillable = ['Role_id', 'Node_id'];

}
