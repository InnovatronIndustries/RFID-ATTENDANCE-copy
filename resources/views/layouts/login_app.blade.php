<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Academe Access | Back Office</title>
		<link rel="icon" type="image/ico" href="{{ asset('assets/logo/ap-logo.png') }}" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	  <!-- Bootstrap -->
    <link href="{{ asset('template/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Custom -->
    <link href="{{ asset('css/custom/login_styles.css') }}" rel="stylesheet" type="text/css" />

	<!-- Theme -->
	<link href="{{ asset('template/assets/css/main.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('template/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('template/assets/css/responsive.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('template/assets/css/icons.css" rel="stylesheet') }}" type="text/css" />
	<!-- Login -->
	<link href="{{ asset('template/assets/css/login.css') }}" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ asset('template/assets/css/fontawesome/font-awesome.min.css') }}">
	<!--[if IE 7]>
		<link rel="stylesheet" href="assets/css/fontawesome/font-awesome-ie7.min.css">
	<![endif]-->

	<!--[if IE 8]>
		<link href="assets/css/ie8.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>

	<!--=== JavaScript ===-->
	<script type="text/javascript" src="{{ asset('template/assets/js/libs/jquery-1.10.2.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('template/bootstrap/js/bootstrap.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('template/assets/js/libs/lodash.compat.min.js') }}"></script>

	<!-- Beautiful Checkboxes -->
	<script type="text/javascript" src="{{ asset('template/plugins/uniform/jquery.uniform.min.js') }}"></script>
	<!-- Form Validation -->
	<script type="text/javascript" src="{{ asset('template/plugins/validation/jquery.validate.min.js') }}"></script>
	<!-- Slim Progress Bars -->
	<script type="text/javascript" src="{{ asset('template/plugins/nprogress/nprogress.js') }}"></script>
	<!-- App -->
    <script type="text/javascript" src="{{ asset('template/assets/js/login.js') }}"></script>
	<script>
	$(document).ready(function(){
		"use strict";
		Login.init(); // Init login JavaScript
	});
	</script>
</head>

<body class="login dynamicBG">
	<div class="box" id="app">
		@yield('content')
	</div>

	@yield('other-links')
</body>
</html>
