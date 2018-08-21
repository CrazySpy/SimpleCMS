<form id="submitForm">
	@csrf
	@inject('roleService', 'App\Services\CmsManage\RoleService')
	{!! $roleService->getGrantNodeTree($nodeIdTree, $nodeDict, $role) !!}
	<div class="form-group">
		<div class="col-md-offset-2 tc">
			<div class="col-md-3"><button class="btn btn-block btn-primary ajax" ajax-type="POST" ajax-target="{{ route('role.grant.grant', $role->id) }}" ajax-form="#submitForm" ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent('{{ route('role.list') }}')}}});" type="button">确认</button></div>
		</div>
	</div>
</form>
