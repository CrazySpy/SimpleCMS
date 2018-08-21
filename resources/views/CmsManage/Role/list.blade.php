<a class="btn btn-primary btn-sm content-link" href="{{ route('role.add.show') }}"><i class="fa fa-plus"></i> 添加</a>

<div class="btn btn-success confirm-ajax btn-sm" confirm-info="您确定要执行启用操作吗?" ajax-target='{{ route('role.changeStatus.enable')}}' ajax-form='#submitForm' ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent(getContentUrl());}}});"><i class="fa fa-play"></i> 启用</div>

<div class="btn btn-warning confirm-ajax btn-sm" confirm-info="您确定要执行禁用操作吗?" ajax-target='{{ route('role.changeStatus.disable')}}' ajax-form='#submitForm' ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent(getContentUrl());}}});"><i class="fa fa-pause"></i> 禁用</div>

<div class="btn btn-danger confirm-ajax btn-sm" confirm-info="您确定要执行删除操作吗?" ajax-target='{{ route('role.delete.delete') }}' ajax-type='POST' ajax-form='#submitForm' ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent(getContentUrl());}}});"><i class="fa fa-trash"></i> 删除</div>

<form id="submitForm" ajax-form-csrf="{{ csrf_token() }}">
	<table class="table table-responsive table-bordered table-hover dataTable" width="100%">
		<thead>
			<th class="bs-checkbox checkbox-toggle" style="width: 36px; ">
				<div class="th-inner ">
					<input id="btSelectAll" type="checkbox"></div></th>
			<th>id</th>
			<th>名称</th>
			<th>备注</th>
			<th>状态</th>
			<th>操作</th>
		</thead>
		@foreach($roles as $role)
		<tr>
			<td class="bs-checkbox checkbox-toggle"><input data-index="0" name="ids[]" type="checkbox" value="{{ $role->id }}"></td>
			<td>{{ $role->id }}</td>
			<td>{{ $role->name }}</td>
			<td>{{ $role->remark }}</td>
			<td>
				@if($role->status == '1')
				<span class="fa fa-check text-success"></span>
				@else
				<span class="fa fa-close text-failed"></span>
				@endif

			</td>
			<td>
				<a class="btn btn-primary btn-xs content-link" href="{{ route('role.edit.show', $role->id) }}" style="margin-right:6px;"><i class="fa fa-edit"></i>
				</a>
				<div class="btn btn-danger btn-xs confirm-ajax" confirm-info="您确定要执行删除操作吗?" ajax-type='POST' ajax-target='{{ route('role.delete.delete') }}' ajax-data="{'ids[]':'{{ $role->id }}', '_token' : '{{ csrf_token() }}'}" ajax-success-callback="object.parents('tr').fadeOut();"  style="margin-right:6px;"><i class="fa fa-trash"></i> </div>
				<a class="btn btn-success btn-xs content-link" href="{{ route('role.grant.show', $role->id) }}" style="margin-right:6px;"><i class="fa fa-key"></i>角色授权</a>
			</td>
		</tr>
		@endforeach
	</table>
</form>
{{ $roles->links() }}
