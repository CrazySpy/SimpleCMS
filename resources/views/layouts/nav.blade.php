<!-- Logo -->
<a href="/" class="logo">
	<!-- mini logo for sidebar mini 50x50 pixels -->
	<span class="logo-mini"><b>A</b>LT</span>
	<!-- logo for regular state and mobile devices -->
	<span class="logo-lg"><b>Admin</b>LTE</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
	<!-- Sidebar toggle button-->
	<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
		<span class="sr-only">Toggle navigation</span>
	</a>

	<div class="navbar-custom-menu">
		<ul class="nav navbar-nav">
			<!-- User Account: style can be found in dropdown.less -->
			<li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="{{ route('avatar') }}" class="user-image" alt="User Image">
					<span class="hidden-xs">{{ $authenticatedAdmin->username }}</span>
				</a>
				<ul class="dropdown-menu">
					<!-- User image -->
					<li class="user-header">
						<img src="{{ route('avatar') }}" class="img-circle" alt="User Image">
						<p>
							{{ $authenticatedAdmin->username }}
							<small>注册于{{ $authenticatedAdmin->createTime }}</small>
						</p>
					</li>
					<!-- Menu Footer-->
					<li class="user-footer">
						<div class="pull-left">
							<a href="{{ route('admin.edit.show', $authenticatedAdmin->id) }}" class="btn btn-default btn-flat content-link">用户信息</a>
						</div>
						<div class="pull-right">
							<a href="{{ route('logout') }}" class="btn btn-default btn-flat">登出</a>
						</div>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</nav>
