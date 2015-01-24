<!DOCTYPE html>
<html lang="de">
	<head>
		<% base_tag %>
	    <meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <title>Daniek::ch</title>
		
		<!-- core CSS -->
	    <link href="{$ThemeDir}/css/bootstrap.min.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/font-awesome.min.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/animate.min.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/prettyPhoto.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/main.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/responsive.css" rel="stylesheet">
	    <!--[if lt IE 9]>
	    <script src="{$ThemeDir}/js/html5shiv.js"></script>
	    <script src="{$ThemeDir}/js/respond.min.js"></script>
	    <![endif]-->       
	    <link rel="shortcut icon" href="{$ThemeDir}/images/ico/favicon.ico">
	    
	    <% include GoogleAnalytics %>
		
	</head><!--/head-->
	
	<body class="homepage">
	
	    <% include Header %>
		
		$Layout
		$Form
	
		<% include Bottom %>
		
		<% include Footer %>
		
	    <script src="{$ThemeDir}/js/jquery.js"></script>
	    <script src="{$ThemeDir}/js/bootstrap.min.js"></script>
	    <script src="{$ThemeDir}/js/jquery.prettyPhoto.js"></script>
	    <script src="{$ThemeDir}/js/jquery.isotope.min.js"></script>
	    <script src="{$ThemeDir}/js/main.js"></script>
	    <script src="{$ThemeDir}/js/wow.min.js"></script>
	    
	</body>
</html>