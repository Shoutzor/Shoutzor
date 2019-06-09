<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<meta http-equiv="Content-Language" content="en" />
		<meta name="msapplication-TileColor" content="#2d89ef">
		<meta name="theme-color" content="#4188c9">
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="mobile-web-app-capable" content="yes">
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">

		<link rel="icon" href="./favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" type="image/x-icon" href="./favicon.ico" />

		<title>{% block title %}Shoutz0r{% endblock %}</title>

		<link href="./assets/css/dashboard.css" rel="stylesheet" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">

		<script src="./assets/js/require.min.js" async></script>
		<script defer>
			requirejs.config({
					baseUrl: '.'
			});
		</script>

		<script src="./assets/plugins/input-mask/plugin.js" async></script>
	</head>

	<body class="">
		<div class="page">
			<div class="page-main">
				<div class="header py-4">
					<div class="container">
						<div class="d-flex">
							<a class="header-brand" href="/">
								<img src="./demo/brand/tabler.svg" class="header-brand-img" alt="shoutzor logo">
							</a>
							<div class="d-flex order-lg-2 ml-auto">
								<div class="nav-item d-none d-md-flex">
									<a href="/admin" class="btn btn-sm btn-outline-primary" target="_blank">Admin Settings</a>
								</div>
								<div class="dropdown">
									<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
										<span class="avatar" style="background-image: url(./demo/faces/female/25.jpg)"></span>
										<span class="ml-2 d-none d-lg-block">
											<span class="text-default">Jane Pearson</span>
											<small class="text-muted d-block mt-1">Administrator</small>
										</span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a class="dropdown-item" href="#">
											<i class="dropdown-icon fe fe-user"></i> Profile
										</a>
										<a class="dropdown-item" href="#">
											<i class="dropdown-icon fe fe-settings"></i> Settings
										</a>
										<a class="dropdown-item" href="#">
											<i class="dropdown-icon fe fe-log-out"></i> Sign out
										</a>
									</div>
								</div>
							</div>
							<a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
								<span class="header-toggler-icon"></span>
							</a>
						</div>
					</div>
				</div>

				<?php echo $this->getContent(); ?>

			</div>
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center">
						<div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
							{% block footer %}Copyright © <a href="https://shoutzor.jorinvermeulen.com">Shoutz0r</a>, All rights reserved. | Powered by <a href="https://tabler.io/">Tabler</a>{% endblock %}
						</div>
					</div>
				</div>
			</footer>
		</div>
	</body>
</html>
