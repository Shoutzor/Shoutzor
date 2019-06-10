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
    <meta name="msapplication-TileColor" content="#2b5797"/>
    <meta name="theme-color" content="#ffffff"/>

    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/appicon/apple-touch-icon.png"/>
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/appicon/favicon-32x32.png"/>
    <link rel="icon" type="image/png" sizes="194x194" href="/assets/images/appicon/favicon-194x194.png"/>
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/images/appicon/android-chrome-192x192.png"/>
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/appicon/favicon-16x16.png"/>
    <link rel="manifest" href="/assets/images/appicon/site.webmanifest"/>
    <link rel="mask-icon" href="/assets/images/appicon/safari-pinned-tab.svg" color="#5bbad5"/>

		<title>{% block title %}Shoutz0r{% endblock %}</title>

    <?php echo $this->assets->outputCss(); ?>
	</head>

	<body class="">
		<div class="page">

      <?php echo $this->getContent(); ?>

		</div>

    <?php echo $this->assets->outputJs(); ?>
    <?php echo $this->assets->outputInlineJs(); ?>
	</body>
</html>
