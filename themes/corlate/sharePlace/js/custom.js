jQuery(document).ready(function($){
	
	$("#btnNewPost").click(function() {
	  $("#uploadForm").fadeToggle("slow");
	});
});

function initShareplaces(relativUrl) {
	$("#imgLoading").fadeIn();
	$("#cd-timeline").load(relativUrl + "/getsharedplaces", function() {
		$("#imgLoading").remove();
		$("#cd-timeline").show();
		var moreButtonArea = $('#moreButtonArea').remove();
		moreButtonArea.appendTo('#sharePlace-info');
	});
}

function setGeoLocation() {
	
	if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}

function showPosition(position) {
	
	$('#SharePlaceUploadForm_SharePlaceUploadForm_Lat').val(position.coords.latitude);
	$('#SharePlaceUploadForm_SharePlaceUploadForm_Lng').val(position.coords.longitude);
	
	var pyrmont = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	
	var request = {
		    location: pyrmont,
		    radius: '500',
		    types: ['locality']
		};
	
	var map = new google.maps.Map(document.getElementById('temp-map'));
	service = new google.maps.places.PlacesService(map);
	service.nearbySearch(request, callbackNearbySearch);
}

function callbackNearbySearch(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
    	if( results[i].html_attributions) {
			$('#SharePlaceUploadForm_SharePlaceUploadForm_NearBy').val(results[i].html_attributions.name);
			$('#SharePlaceUploadForm_SharePlaceUploadForm_NearBy_Icon').val(results[i].html_attributions.icon);
		}
    }
  }
}