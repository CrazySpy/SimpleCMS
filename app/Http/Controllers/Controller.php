<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public $accessIgnore = [];

	public function jsonReturn($id, $type, $msg, $status = 200)
	{
		return Response()->json(['id' => $id, 'type' => $type, 'message' => $msg], $status);
	}
		
	public function success($id, $msg)
	{
		return $this->jsonReturn($id, 'success', $msg);
	}

	public function error($id, $msg)
	{
		return $this->jsonReturn($id, 'error', $msg, 403);
	}
}
