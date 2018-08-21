<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		@include('layouts.head')
		<!-- jQuery 3 -->
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
		<script src="/js/web.js"></script>
		<!-- AdminLTE App -->
		<script src="/js/adminlte.min.js"></script>
		<!-- Bootstrap 3.3.7 -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.css">
		<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<!-- Font Awesome -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">	  <!-- Theme style -->
		<link rel="stylesheet" href="/css/AdminLTE.min.css">
		<!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
		<link rel="stylesheet" href="/css/skins/_all-skins.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper">
			<header class="main-header">
				@include('layouts.nav')
			</header>
			<!-- Left side column. contains the logo and sidebar -->
			<aside class="main-sidebar">
				@include('layouts.sidebar')
			</aside>
			<!-- Content Wrapper. Contains page content -->
			<main class="content-wrapper">
				<section class="content pt-5">
				</section>
			</main>
		</div>
		<!-- ./wrapper -->
	</body>
</html>
