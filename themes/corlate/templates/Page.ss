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
	                    <div id="logo">{ daniek::ch }</div>
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
	                        <h3>Reisen</h3>
	                        <ul>
	                            <li><a href="{$BaseHref}reisen/oman">Oman</a></li>
	                            <li><a href="{$BaseHref}reisen/kanada">Kanada</a></li>
	                            <li><a href="{$BaseHref}reisen/schottland">Schottland</a></li>
	                        </ul>
	                    </div>    
	                </div>
	
	                <div class="col-md-3 col-sm-6">
	                    <div class="widget">
	                        <h3>Movecount</h3>
	                        <ul>
	                            <li><a href="{$BaseHref}movecount">Routen</a></li>
	                        </ul>
	                    </div>    
	                </div>
	
	                <div class="col-md-3 col-sm-6">
	                    <div class="widget">
	                        <h3>Home</h3>
	                        <ul>
	                            <li><a href="{$BaseHref}">Home</a></li>
	                        </ul>
	                    </div>    
	                </div>
	
	                <div class="col-md-3 col-sm-6">
	                    <div class="widget">
	                        <h3>Kontakt</h3>
	                        <ul>
	                            <li><a href="{$BaseHref}kontakt">Kontakt</a></li>
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
	                    &copy; {$Now.Year} <a target="_blank" href="{$BaseHref}" title="Daniek">Daniek</a>. All Rights Reserved.
	                </div>
	                <div class="col-sm-6">
	                    <ul class="pull-right">
	                        <li><a href="{$BaseHref}">Home</a></li>
	                        <li><a href="{$BaseHref}kontakt">Kontakt</a></li>
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