<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
	<!-- Sidebar user panel -->
	<div class="user-panel">
		<div class="pull-left image">
			<img src="{{ route('avatar') }}" class="img-circle" alt="User Image">
		</div>
		<div class="pull-left info">
			<p>{{ $authenticatedAdmin->username }}</p>
			<p>{{ empty($authenticatedAdminRole) ? '无角色' : $authenticatedAdminRole->name }}</p>
		</div>
	</div>
	<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu" data-widget="tree">
		@inject('nodeService', 'App\Services\CmsManage\NodeService')
		{!! $nodeService->getSidebarTree() !!}
	</ul>
</section>
<!-- /.sidebar -->
