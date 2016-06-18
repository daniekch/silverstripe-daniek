<!DOCTYPE html>
<html lang="de">
	<head>
		<% base_tag %>
	    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title><% if $MetaTitle %>{$MetaTitle}<% else %>{$Title}<% end_if %><% if $Subtitle %> - {$Subtitle}<% end_if %></title>
		<meta name="description" content="{$MetaDescription}" />
		<meta name="robots" content="{$MetaRobots}" />
		
		<!-- core CSS -->
	    <link href="{$ThemeDir}/css/bootstrap.min.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/font-awesome.min.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/animate.min.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/prettyPhoto.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/main.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/custom.css" rel="stylesheet">
	    <link href="{$ThemeDir}/css/responsive.css" rel="stylesheet">
	    <!--[if lt IE 9]>
	    <script src="{$ThemeDir}/js/html5shiv.js"></script>
	    <script src="{$ThemeDir}/js/respond.min.js"></script>
	    <![endif]-->       
	    <link rel="shortcut icon" href="{$ThemeDir}/images/ico/favicon.ico">
	    
	    <script src="{$ThemeDir}/js/jquery.js"></script>
	    <script src="{$ThemeDir}/js/bootstrap.min.js"></script>
	    <script src="{$ThemeDir}/js/jquery.prettyPhoto.js"></script>
	    <script src="{$ThemeDir}/js/jquery.isotope.min.js"></script>
	   	<script src="{$ThemeDir}/js/wow.min.js"></script>
	    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcnMB1og1wojVokC1iG3nJBnLBcDwgbgE&libraries=places"></script>
	    
	    <% include GoogleAnalytics %>
		
	</head><!--/head-->
	
	<body class="homepage">
	
	    <% include Header %>
		
		$Layout
		$Form
	
		<% include Bottom %>
		
		<% include Footer %>
		
	    <script src="{$ThemeDir}/js/main.js"></script>

	</body>
</html>