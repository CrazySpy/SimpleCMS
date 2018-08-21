<a class="btn btn-primary btn-sm content-link" href="{{ route('admin.add.show') }}"><i class="fa fa-plus"></i> 添加</a>

<div class="btn btn-success confirm-ajax btn-sm" confirm-info="您确定要执行启用操作吗?" ajax-target='{{ route('admin.changeStatus.enable')}}' ajax-form='#submitForm' ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent(getContentUrl());}}});"><i class="fa fa-play"></i> 启用</div>

<div class="btn btn-warning confirm-ajax btn-sm" confirm-info="您确定要执行禁用操作吗?" ajax-target='{{ route('admin.changeStatus.disable')}}' ajax-form='#submitForm' ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent(getContentUrl());}}});"><i class="fa fa-pause"></i> 禁用</div>

<div class="btn btn-danger confirm-ajax btn-sm" confirm-info="您确定要执行删除操作吗?" ajax-target='{{ route('admin.delete.delete') }}' ajax-type='POST' ajax-form='#submitForm' ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent(getContentUrl());}}});"><i class="fa fa-trash"></i> 删除</div>

<div class="box-tools pull-right">
	<div class="has-feedback">
		<input type="text" class="form-control input-sm" placeholder="搜索用户名" value="{{ old('keyword') }}">
		<span class="glyphicon glyphicon-search form-control-feedback"></span>
	</div>
</div>

<form id='submitForm' ajax-form-csrf='{{ csrf_token() }}'>
	<table class="table table-responsive table-bordered table-hover dataTable" width="100%">
		<thead>
			<th class="bs-checkbox checkbox-toggle" style="width: 36px; ">
				<div class="th-inner ">
					<input id="btSelectAll" type="checkbox">
				</div>
			</th>
			<th>id</th>
			<th>用户名</th>
			<th>邮箱</th>
			<th>角色</th>
			<th>状态</th>
			<th>操作</th>
		</thead>
		@foreach($admins as $admin)
		<tr>
			<td class="bs-checkbox checkbox-toggle"><input data-index="0" name="ids[]" type="checkbox" value="{{ $admin->id }}"></td>
			<td>{{ $admin->id }}</td>
			<td>{{ $admin->username }}</td>
			<td>
				@if(isset($admin->email))
				{{ $admin->email }}
				@else
				未设置
				@endif
			</td>
			<td>{{ $admin->role }}</td>
			<td>
				@if($admin->status == '1')
				<span class="fa fa-check text-success"></span>
				@else
				<span class="fa fa-close text-failed"></span>
				@endif

			</td>
			<td>
				<a class="btn btn-primary btn-xs content-link" href="{{ route('admin.edit.show', $admin->id) }}" style="margin-right:6px;"><i class="fa fa-edit"></i></a>
				<div class="btn btn-danger btn-xs confirm-ajax" confirm-info="您确定要删除{{ $admin->name }}吗?" ajax-type='POST' ajax-target='{{ route('admin.delete.delete') }}' ajax-data="{'ids[]':'{{ $admin->id }}', '_token' : '{{ csrf_token() }}'}" ajax-success-callback="object.parents('tr').fadeOut();" style="margin-right:6px;"><i class="fa fa-trash"></i></a></td>
		</tr>
		@endforeach
	</table>
</form>
{{ $admins->links() }}
