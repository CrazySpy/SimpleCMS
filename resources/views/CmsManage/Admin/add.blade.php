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
					<input type="hidden" class="form-control" id="id" name="id" value="{{ old('id') }}">
					<div class="form-group">
						<label for="username" class="col-md-2 control-label">用户名</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="username" value="{{ old('username') }}">
						</div>
						<div class="col-md-5 help-block"><i class="fa fa-info-circle color-info1"></i> 可以作为登录名称</div>
					</div>

					<div class="form-group">
						<label for="password" class="col-md-2 control-label">密码</label>
						<div class="col-md-4">
							<input type="password" class="form-control" name="password" value="">
						</div>
						<div class="col-md-5 help-block"><i class="fa fa-info-circle color-info1"></i>登录凭据</div>
					</div>

					<div class="form-group">
						<label for="password_confirmation" class="col-md-2 control-label">重复登录密码</label>
						<div class="col-md-4">
							<input type="password" class="form-control" name="password_confirmation">
						</div>
					</div>

					<div class="form-group">
						<label for="email" class="col-md-2 control-label">邮箱</label>
						<div class="col-md-4">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">
						</div>
						<div class="col-md-5 help-block"><i class="fa fa-info-circle color-info1"></i> 邮箱，可以作为登录名称</div>
					</div>


					<div class="form-group">
						<label for="role" class="col-md-2 control-label">角色</label>
						<div class="col-md-4">
							<select name="role" id="role" class="form-control">
								<option value="0" @if(isset($admin->role) && $admin->role == '0')selected @endif>无</option>
								@foreach($validRoles as $validRole)
								<option value="{{ $validRole->id }}"
				@if(isset($admin->id) && $validRole->id == $admin->Role_id)
				selected 
				@elseif(old('Role_id') == $validRole->id) 
				selected
				@endif
				>{{ $validRole->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="form-group">
						<label for="status" class="col-md-2 control-label">状态</label>
						<div class="col-md-4">
							<select name="status" id="status" class="form-control">
								<option value="0"
				@if(isset($admin->status) && $admin->status == 0)
				selected
				@elseif(old('status') == 0)
				selected
				@endif
				>禁用</option>
								<option value="1" 
				@if(isset($admin->status) && $admin->status == 1)
				selected
				@elseif(old('status') == 1)
				selected
				@endif
				>启用</option>
							</select>
						</div>
					</div>

					<div class="form-group">
					</div>

				</fieldset>
			</form>
			<div class="col-md-10 col-xs-offset-2 mt-10 tc">
				<div class="col-md-3 col-xs-6">
					<button class="btn btn-block btn-primary ajax" type="button" ajax-form="#submitForm" ajax-target="{{ $action }}"  ajax-type="POST" ajax-success-callback="$.alert({'content' : rtn.message,'title' : '提示', 'buttons' : {'ok' : function(){setContent('{{ route('admin.list') }}')}}});">确定</button>
				</div>
			</div>
		</div> 
	</div>
</div>
