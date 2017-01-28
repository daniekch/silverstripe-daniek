<section id="main-slider" class="no-margin">
    <div class="carousel slide">
        <ol class="carousel-indicators">
        	<% loop Slider %>
            	<li data-target="#main-slider" data-slide-to="{$Count}" class="<% if $First %>active<% end_if %>"></li>
            <% end_loop %>
        </ol>
        <div class="carousel-inner">
			
			<% loop Slider %>
				<% if $BackgroundImage %>
					<% with $BackgroundImage %>
						<div class="item <% if $Up.First %>active<% end_if %>" style="background-image: url({$URL})">
					<% end_with %>
				<% else %>
					<div class="item <% if $Up.First %>active<% end_if %>">
				<% end_if %>
	                <div class="container">
	                    <div class="row slide-margin">
	                        <div class="col-sm-6">
	                            <div class="carousel-content">
	                                <h2 class="animation animated-item-1">{$Title}</h2>
	                                <h3 class="animation animated-item-2">{$Lead}</h3>
	                                <a class="btn-slide animation animated-item-3" href="{$Top.BaseURL}{$Link}">Weiter</a>
	                            </div>
	                        </div>
							
							<% if $OverlayImage %>
		                        <div class="col-sm-6 hidden-xs animation animated-item-4">
		                            <div class="slider-img">
		                            	<% with $OverlayImage %>
		                                	<img src="{$URL}" alt="{$Title}" class="img-responsive">
		                                <% end_with %>
		                            </div>
		                        </div>
	                        <% end_if %>
	
	                    </div>
	                </div>
	                
	            </div>
            <% end_loop %>

        </div>
    </div>
    <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
        <i class="fa fa-chevron-left"></i>
    </a>
    <a class="next hidden-xs" href="#main-slider" data-slide="next">
        <i class="fa fa-chevron-right"></i>
    </a>
</section>