<div class="builder formbuilder-box">
	<div class="row">
		@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif	
	</div>
	<div class="row">    
		<div class="col-md-11" style="padding: 20px;margin-left:30px;border-radius:3px;">      
			<form id="submitForm" method="post" class="form-builder form-horizontal nice-validator n-default n-bootstrap">
				@csrf
				<fieldset>
					<input type="hidden" class="form-control" id="id" name="id" value="@if(isset($node->id)){{ $node->id }}@endif">

					<div class="form-group">
						<label for="name" class="col-md-2 control-label">名称</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="name" value="@if(isset($node->name)){{  $node->name  }}@endif">
						</div>
						<div class="col-md-5 help-block"><i class="fa fa-info-circle color-info1"></i> 菜单显示的名称</div>
					</div>

					<div class="form-group">
						<label for="accessTag" class="col-md-2 control-label">权限标识</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="accessTag" value="@if(isset($node->accessTag)){{  $node->accessTag  }}@else{{ old('accessTag') }}@endif">
						</div>
						<div class="col-md-5 help-block"><i class="fa fa-info-circle color-info1"></i> 用于控制访问权限，控制器全名，需要指定方法名则在控制器全名后面添加@methodName</div>
					</div>

					<div class="form-group">
						<label for="uri" class="col-md-2 control-label">uri</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="uri" value="@if(isset($node->uri)){{  $node->uri }}@endif">
						</div>
						<div class="col-md-5 help-block"><i class="fa fa-info-circle color-info1"></i> 菜单要跳转的页面(折叠项留空)</div>
					</div>

					<div class="form-group">
						<label for="sort" class="col-md-2 control-label">排序</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="sort" value="@if(isset($node->sort)){{  $node->sort }}@endif">
						</div>
						<div class="col-md-5 help-block"><i class="fa fa-info-circle color-info1"></i> 整数，根据这个整数对菜单项进行排序</div>
					</div>

					<div class="form-group">
						<label for="remark" class="col-md-2 control-label">备注</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="remark" value="@if(isset($node->remark)){{  $node->remark }}@endif">
						</div>
					</div>

					<div class="form-group">
						<label for="pid" class="col-md-2 control-label">顶级节点</label>
						<div class="col-md-4">
							<select name="pid" id="pid" class="form-control">
								<option value="0" @if(isset($node->pid) && $node->pid == '0')selected @endif>顶级菜单</option>
								@foreach($validNodes as $validNode)
								@if(isset($node->id) && $validNode->id == $node->id)
								@continue
								@endif
								<option value="{{ $validNode->id }}"
				@if(isset($node->id) && $validNode->id == $node->pid)
				selected 
				@elseif(old('pid') == $validNode->id) 
				selected
				@endif
				>{{ $validNode->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="status" class="col-md-2 control-label">状态</label>
						<div class="col-md-4">
							<select name="status" id="status" class="form-control">
								<option value="0"
				@if(isset($node->status) && $node->status == 0)
				selected
				@elseif(old('status') == 0)
				selected
				@endif
				>禁用</option>
								<option value="1" 
				@if(isset($node->status) && $node->status == 1)
				selected
				@elseif(old('status') == 1)
				selected
				@endif
				>启用</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-10 col-xs-offset-2 mt-10 tc">
							<div class="col-md-3 col-xs-6">
								<button class="btn btn-block btn-primary ajax" type="button" ajax-form="#submitForm" ajax-target="{{ $action }}"  ajax-type="POST" ajax-success-callback="setContent('{{ route('node.list') }}')" ajax-error-callback="$.alert({'content' : rtn.message,'title' : '提示'});">确定</button>
							</div>
						</div>
					</div>

				</fieldset>
			</form>
		</div> 
	</div>
</div>
