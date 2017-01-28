<header id="header">
    <div class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-4">
                    
                </div>
                <div class="col-sm-6 col-xs-8">
                   	<div class="social">
                		<ul class="social-share login">
                			<li>
                			<% if $CurrentMember %>
                				Willkommen {$CurrentMember.Name} <a href="{$baseHref}Security/logout">Log out</a>
							<% else %>
								<a href="{$baseHref}Security/login">Log in</a>
							<% end_if %>
							</li>
                		</ul>
                        <div class="search">
                            <form>
                                <input type="text" class="search-form" autocomplete="off" placeholder="Search">
                                <i class="fa fa-search"></i>
                            </form>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
            	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
	                <span class="sr-only">Toggle navigation</span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
                </button>
                <div id="logo">{ daniek::ch }</div>
            </div>

            <div class="collapse navbar-collapse navbar-right">
            	<% include Navigation %>
            </div>
        </div>
    </nav>

</header>