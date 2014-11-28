<!DOCTYPE HTML>
<html lang="en-US">
	<head>
		<% base_tag %>
		<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		$MetaTags(false)

		<link rel="shortcut icon" type="image/x-icon" href="{$ThemeDir}/images/favicon.png" />
		<link rel="stylesheet" type="text/css" href="{$ThemeDir}/css/style.css" media="all" />
		<link href='http://fonts.googleapis.com/css?family=Amaranth' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Droid+Serif:400,400italic,700,700italic' rel='stylesheet' type='text/css'>
		<!--[if IE 7]>
		<link rel="stylesheet" type="text/css" href="{$ThemeDir}/css/ie7.css" media="all" />
		<![endif]-->
		<!--[if IE 8]>
		<link rel="stylesheet" type="text/css" href="{$ThemeDir}/css/ie8.css" media="all" />
		<![endif]-->
		<!--[if IE 9]>
		<link rel="stylesheet" type="text/css" href="{$ThemeDir}/css/ie9.css" media="all" />
		<![endif]-->
		<script type="text/javascript" src="{$ThemeDir}/javascript/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="{$ThemeDir}/javascript/ddsmoothmenu.js"></script>
		<script type="text/javascript" src="{$ThemeDir}/javascript/jquery.jcarousel.js"></script>
		<script type="text/javascript" src="{$ThemeDir}/javascript/jquery.prettyPhoto.js"></script>
		<script type="text/javascript" src="{$ThemeDir}/javascript/carousel.js"></script>
		<script type="text/javascript" src="{$ThemeDir}/javascript/jquery.flexslider-min.js"></script>
		<script type="text/javascript" src="{$ThemeDir}/javascript/jquery.masonry.min.js"></script>
		<script type="text/javascript" src="{$ThemeDir}/javascript/jquery.slickforms.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<div id="sidebar">

				 <div id="logo">
				 	<a href=""><img src="{$ThemeDir}/images/logo.png" alt="Caprice" /></a>
				 </div>
				 
				 <% include Navigation %>
			  
				<div class="sidebox">
					<ul class="share">
						<li><a href="#"><img src="{$ThemeDir}/images/icon-rss.png" alt="RSS" /></a></li>
						<li><a href="#"><img src="{$ThemeDir}/images/icon-facebook.png" alt="Facebook" /></a></li>
						<li><a href="#"><img src="{$ThemeDir}/images/icon-twitter.png" alt="Twitter" /></a></li>
						<li><a href="#"><img src="{$ThemeDir}/images/icon-dribbble.png" alt="Dribbble" /></a></li>
						<li><a href="#"><img src="{$ThemeDir}/images/icon-linkedin.png" alt="LinkedIn" /></a></li>
					</ul>
				</div>
			
			</div>
		
			<div id="content">			
				$Form
				$Layout
			</div>
		</div>		
		<div class="clear"></div>
		
		<script type="text/javascript" src="{$ThemeDir}/javascript/scripts.js"></script>
		<!--[if !IE]> -->
		<script type="text/javascript" src="{$ThemeDir}/javascript/jquery.corner.js"></script>
		<!-- <![endif]-->
	</body>
</html>