<% if $ShowGoogleMapWidget %>
	<div class="widget blog_googlemap">
	    <h3>Route</h3>
		
		<script>
			function initialize() {
				var LatLng = new google.maps.LatLng({$DefaultLat},{$DefaultLng});
			  	var mapOptions = {
			    	zoom: {$DefaultZoom},
			    	center: LatLng
			  	}
			
			  	var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			
			  	var ctaLayer = new google.maps.KmlLayer({
			    	url: '{$KmlUrl}'
			  	});
			  	ctaLayer.setMap(map);
			}
			
			google.maps.event.addDomListener(window, 'load', initialize);
		
		</script>
		    
		<div id="map-canvas" style="height: 275px; margin: 0px; padding: 0px;"></div>
	</div>
<% end_if %>