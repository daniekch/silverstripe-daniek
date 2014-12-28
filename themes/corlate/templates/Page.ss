<!DOCTYPE html>
<html lang="en">
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
	    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{$ThemeDir}/images/ico/apple-touch-icon-144-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{$ThemeDir}/images/ico/apple-touch-icon-114-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{$ThemeDir}/images/ico/apple-touch-icon-72-precomposed.png">
	    <link rel="apple-touch-icon-precomposed" href="{$ThemeDir}/images/ico/apple-touch-icon-57-precomposed.png">
	</head><!--/head-->
	
	<body class="homepage">
	
	    <header id="header">
	        <div class="top-bar">
	            <div class="container">
	                <div class="row">
	                    <div class="col-sm-6 col-xs-4">
	                        
	                    </div>
	                    <div class="col-sm-6 col-xs-8">
	                       <div class="social">
	                            <div class="search">
	                                <form role="form">
	                                    <input type="text" class="search-form" autocomplete="off" placeholder="Search">
	                                    <i class="fa fa-search"></i>
	                                </form>
	                           </div>
	                       </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	
	        <nav class="navbar navbar-inverse" role="banner">
	            <div class="container">
	                <div class="navbar-header">
	                    { daniek::ch }
	                </div>
					
	                <div class="collapse navbar-collapse navbar-right">
	                
	                	<% include Navigation %>
	                    
	                </div>
	            </div>
	        </nav>
			
	    </header>
		
		$Layout
		$Form
	
	    <section id="bottom">
	        <div class="container wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="600ms">
	            <div class="row">
	                <div class="col-md-3 col-sm-6">
	                    <div class="widget">
	                        <h3>Company</h3>
	                        <ul>
	                            <li><a href="#">About us</a></li>
	                            <li><a href="#">We are hiring</a></li>
	                            <li><a href="#">Meet the team</a></li>
	                            <li><a href="#">Copyright</a></li>
	                            <li><a href="#">Terms of use</a></li>
	                            <li><a href="#">Privacy policy</a></li>
	                            <li><a href="#">Contact us</a></li>
	                        </ul>
	                    </div>    
	                </div>
	
	                <div class="col-md-3 col-sm-6">
	                    <div class="widget">
	                        <h3>Support</h3>
	                        <ul>
	                            <li><a href="#">Faq</a></li>
	                            <li><a href="#">Blog</a></li>
	                            <li><a href="#">Forum</a></li>
	                            <li><a href="#">Documentation</a></li>
	                            <li><a href="#">Refund policy</a></li>
	                            <li><a href="#">Ticket system</a></li>
	                            <li><a href="#">Billing system</a></li>
	                        </ul>
	                    </div>    
	                </div>
	
	                <div class="col-md-3 col-sm-6">
	                    <div class="widget">
	                        <h3>Developers</h3>
	                        <ul>
	                            <li><a href="#">Web Development</a></li>
	                            <li><a href="#">SEO Marketing</a></li>
	                            <li><a href="#">Theme</a></li>
	                            <li><a href="#">Development</a></li>
	                            <li><a href="#">Email Marketing</a></li>
	                            <li><a href="#">Plugin Development</a></li>
	                            <li><a href="#">Article Writing</a></li>
	                        </ul>
	                    </div>    
	                </div>
	
	                <div class="col-md-3 col-sm-6">
	                    <div class="widget">
	                        <h3>Our Partners</h3>
	                        <ul>
	                            <li><a href="#">Adipisicing Elit</a></li>
	                            <li><a href="#">Eiusmod</a></li>
	                            <li><a href="#">Tempor</a></li>
	                            <li><a href="#">Veniam</a></li>
	                            <li><a href="#">Exercitation</a></li>
	                            <li><a href="#">Ullamco</a></li>
	                            <li><a href="#">Laboris</a></li>
	                        </ul>
	                    </div>    
	                </div>
	            </div>
	        </div>
	    </section>
	
	    <footer id="footer" class="midnight-blue">
	        <div class="container">
	            <div class="row">
	                <div class="col-sm-6">
	                    &copy; 2013 <a target="_blank" href="http://shapebootstrap.net/" title="Free Twitter Bootstrap WordPress Themes and HTML templates">ShapeBootstrap</a>. All Rights Reserved.
	                </div>
	                <div class="col-sm-6">
	                    <ul class="pull-right">
	                        <li><a href="#">Home</a></li>
	                        <li><a href="#">About Us</a></li>
	                        <li><a href="#">Faq</a></li>
	                        <li><a href="#">Contact Us</a></li>
	                    </ul>
	                </div>
	            </div>
	        </div>
	    </footer>
	
	    <script src="{$ThemeDir}/js/jquery.js"></script>
	    <script src="{$ThemeDir}/js/bootstrap.min.js"></script>
	    <script src="{$ThemeDir}/js/jquery.prettyPhoto.js"></script>
	    <script src="{$ThemeDir}/js/jquery.isotope.min.js"></script>
	    <script src="{$ThemeDir}/js/main.js"></script>
	    <script src="{$ThemeDir}/js/wow.min.js"></script>
	    
	</body>
</html>