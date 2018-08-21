<a class="btn btn-primary btn-sm content-link" href="{{ route('node.add.show') }}"><i class="fa fa-plus"></i> 添加</a>

<div class="btn btn-success confirm-ajax btn-sm" confirm-info="您确定要执行启用操作吗?" ajax-target='{{ route('node.changeStatus.enable')}}' ajax-form='#submitForm' ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent(getContentUrl());}}});"><i class="fa fa-play"></i> 启用</div>

<div class="btn btn-warning confirm-ajax btn-sm" confirm-info="您确定要执行禁用操作吗?" ajax-target='{{ route('node.changeStatus.disable')}}' ajax-form='#submitForm' ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent(getContentUrl());}}});"><i class="fa fa-pause"></i> 禁用</div>

<div class="btn btn-danger confirm-ajax btn-sm" confirm-info="您确定要执行删除操作吗?" ajax-target='{{ route('node.delete.delete') }}' ajax-type='POST' ajax-form='#submitForm' ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent(getContentUrl());}}});"><i class="fa fa-trash"></i> 删除</div>

<form id='submitForm' ajax-form-csrf='{{ csrf_token() }}'>
	<table class="table table-responsive table-bordered table-hover dataTable" width="100%">
		<thead>
			<th class="bs-checkbox checkbox-toggle" style="width: 36px; ">
				<div class="th-inner ">
					<input id="btSelectAll" type="checkbox">
				</div>
			</th>
			<th>id</th>
			<th>名称</th>
			<th>权限标识</th>
			<th>父节点</th>
			<th>uri</th>
			<th>排序</th>
			<th>备注</th>
			<th>状态</th>
			<th>操作</th>
		</thead>
		@foreach($nodes as $node)
		<tr>
			<td class="bs-checkbox checkbox-toggle"><input name="ids[]" type="checkbox" value="{{ $node->id }}"></td>
			<td>{{ $node->id }}</td>
			<td>{{ $node->name }}</td>
			<td>{{ $node->accessTag}}</td>
			<td>
				@if(isset($node->parentNode['name']))
				{{ $node->parentNode['name'] }}
				@else
				无
				@endif
			</td>
			<td>
				@if(isset($node->uri))
				{{ $node->uri }}
				@else
				无
				@endif
			</td>
			<td>{{ $node->sort }}</td>
			<td>
				@if(isset($node->remark))
				{{ $node->remark }}
				@else
				无
				@endif
			</td>
			<td>
				@if($node->status == '1')
				<span class="fa fa-check text-success"></span>
				@else
				<span class="fa fa-close text-failed"></span>
				@endif

			</td>
			<td>
				<a class="btn btn-primary btn-xs content-link" href="{{ route('node.edit.show', $node->id) }}" style="margin-right:6px;"><i class="fa fa-edit"></i></a>
				<div class="btn btn-danger btn-xs confirm-ajax" confirm-info="您确定要删除{{ $node->name }}吗?" ajax-type='POST' ajax-target='{{ route('node.delete.delete') }}' ajax-data="{'ids[]':'{{ $node->id }}', '_token' : '{{ csrf_token() }}'}" ajax-success-callback="object.parents('tr').fadeOut();" style="margin-right:6px;"><i class="fa fa-trash"></i></div>
			</td>
		</tr>
		@endforeach
	</table>
</form>
{{ $nodes->links() }}
