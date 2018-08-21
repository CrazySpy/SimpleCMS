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
			<form id="submitForm" class="form-builder form-horizontal nice-validator n-default n-bootstrap">
				@csrf
				<fieldset>
					<input type="hidden" class="form-control" id="id" name="id" value="@if(isset($role->id)){{ $role->id }}@else{{ old('id') }}@endif">

					<div class="form-group">
						<label for="name" class="col-md-2 control-label">名称</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="name" value="@if(isset($role->name)){{  $role->name  }}@else{{ old('name') }}@endif">
						</div>
						<div class="col-md-5 help-block"><i class="fa fa-info-circle color-info1"></i> 菜单显示的名称</div>
					</div>

					<div class="form-group">
						<label for="remark" class="col-md-2 control-label">备注</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="remark" value="@if(isset($role->remark)){{  $role->remark }}@else{{ old('remark') }}@endif">
						</div>
					</div>

					<div class="form-group">
						<label for="status" class="col-md-2 control-label">状态</label>
						<div class="col-md-4">
							<select name="status" id="status" class="form-control">
								<option value="0"
				@if(isset($role->status) && $role->status == 0)
				selected
				@elseif(old('status') == 0)
				selected
				@endif
				>禁用</option>
								<option value="1" 
				@if(isset($role->status) && $role->status == 1)
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
								<button class="btn btn-block btn-primary submit ajax" ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent('{{ route('role.list') }}')}}});" ajax-type="POST" ajax-target="{{ $action }}" ajax-form="#submitForm" type="button">确定</button>
							</div>
						</div>
					</div>
				</fieldset>
			</form>
		</div> 
	</div>
</div>
