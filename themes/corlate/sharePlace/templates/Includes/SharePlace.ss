<% if SharePlaces %>
	<% loop SharePlaces %>
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
						<% with $Picture %>
							<img class="img-responsive img-blog" src="{$URL}" alt="{$Up.Title}" />
						<% end_with %>
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
					<% else_if $ShareType == 'Text' %>
						{$Comments}
					<% end_if %>
					
					<% if $NearBy %>
						<a href="" class="nearby">{$NearBy}</a>
					<% end_if %>
				</p>
				<span class="cd-date">{$Created.Format("d.m.Y")}</span>
			</div>
		</div>
	<% end_loop %>
	<% if ShowMoreLink %>
		<div class="center" id="moreButtonArea">
			<img src="themes/corlate/sharePlace/images/loading.svg" alt="Loading" id="imgLoading" style="display:none">
			<a href="" title="mehr Anzeigen" class="btn btn-primary btn-lg" id="btnShowMore">mehr Anzeigen</a>
			<script>
				$( "#btnShowMore" ).click(function() {
					event.preventDefault();
					
					$("#btnShowMore").hide();
					$("#imgLoading").fadeIn();
					
					$("<div>").load("{$MoreLink}", function() {
						$("#moreButtonArea").remove();
						$("#cd-timeline").append($(this).html());
						var moreButtonArea = $('#moreButtonArea').remove();
						moreButtonArea.appendTo('#sharePlace-info');
					});
				});
			</script>
		</div>
	<% end_if %>
<% end_if %>