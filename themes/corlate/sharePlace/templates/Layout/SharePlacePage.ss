<% require css("themes/corlate/sharePlace/css/style.css") %>
<% require javascript("themes/corlate/sharePlace/js/modernizr.js") %>
<% require javascript("themes/corlate/sharePlace/js/main.js") %>

<section id="sharePlace-info">
	<div class="center">  
		<h1>{$Title}</h1>
    	{$Content}
	</div>
	<section id="cd-timeline" class="cd-container">
		$getSharedPlaces
	</section>
</section>

