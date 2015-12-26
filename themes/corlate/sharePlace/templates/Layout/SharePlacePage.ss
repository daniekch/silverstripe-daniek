<% require css("themes/corlate/sharePlace/css/style.css") %>
<% require javascript("themes/corlate/sharePlace/js/modernizr.js") %>
<% require javascript("themes/corlate/sharePlace/js/main.js") %>

<section id="sharePlace-info">
	<div class="center">  
		<h1>{$Title}</h1>
    	{$Content}
	</div>
	<section id="cd-timeline" class="cd-container">
		<% loop SharePlace.Sort(Created, DESC) %>
			<div class="cd-timeline-block">
				<% if $ShareType == 'Picture' %>
					<div class="cd-timeline-img cd-picture">
						<img src="themes/corlate/sharePlace/images/cd-icon-picture.svg" alt="Picture">
					</div>
				<% else_if $ShareType == 'Location' %>
					<div class="cd-timeline-img cd-location">
						<img src="themes/corlate/sharePlace/images/cd-icon-location.svg" alt="Location">
					</div>
				<% end_if %>
				<div class="cd-timeline-content">
					<% if $Title %><h2>{$Title}</h2><% end_if %>
					<p>
						<% if $ShareType == 'Picture' %>
							{$Picture.SetWidth(480)}
						<% else_if $ShareType == 'Location' %>
							<script>
								function initialize() {
									var LatLng = {lat: {$Lat}, lng: {$Lng}};
								  	var map = new google.maps.Map(document.getElementById('map-canvas'), {
								  		zoom: 13,
								  		center: LatLng,
								  		disableDefaultUI: true,
								  		mapTypeId: google.maps.MapTypeId.TERRAIN
								  	});
									
								  	var marker = new google.maps.Marker({
								  	    position: LatLng,
								  	    map: map,
								  	    title: '{$Title}'
								  	});
								}
								
								google.maps.event.addDomListener(window, 'load', initialize);
							</script>
							    
							<div id="map-canvas" style="height: 275px; margin: 0px; padding: 0px;"></div>
						<% end_if %>
						{$Comments}
					</p>
					<span class="cd-date">{$Created.Format("d.m.Y")}</span>
				</div>
			</div>
		<% end_loop %>
	</section>
</section>

