<div class="row contact-wrap" style="display: none;" id="uploadForm">
	<% if $Message %>
	    <div id="{$FormName}_error" class="status alert alert-success">{$Message}</div>
	<% else %>
	    <div id="{$FormName}_error" class="status alert alert-success" style="display: none"></div>
	<% end_if %>
      
    <form id="main-contact-form" class="contact-form" $FormAttributes>
    	<div class="row">
	        <div class="col-sm-5">
	            <div class="form-group">
	                <label>{$Fields.dataFieldByName(Title).Title}</label>
	                {$Fields.dataFieldByName(Title)}
	            </div>
	            <div class="form-group">
	                <label>{$Fields.dataFieldByName(Picture).Title}</label>
	                {$Fields.dataFieldByName(Picture)}
	            </div>
	            <div class="form-group">
	                <label>{$Fields.dataFieldByName(Comments).Title}</label>
	                {$Fields.dataFieldByName(Comments)}
	            </div>
	            {$Fields.dataFieldByName(Lat)}
	            {$Fields.dataFieldByName(Lng)}
	            {$Fields.dataFieldByName(SecurityID)}                     
	            <div class="form-group">
	            	<% loop $Actions %>$Field<% end_loop %>
	            </div>
	        </div>
        </div>
        <script type="text/javascript">
	        if (navigator.geolocation) {
	            navigator.geolocation.getCurrentPosition(showPosition);
	        } else {
	            
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
	        	
	        	service = new google.maps.places.PlacesService(map);
	        	service.nearbySearch(request, callback);
	        }
	        
	        function callback(results, status) {
	        	  if (status == google.maps.places.PlacesServiceStatus.OK) {
	        	    for (var i = 0; i < results.length; i++) {
	        	      var place = results[i];
	        	      alert(results[i]);
	        	    }
	        	  }
	        	}
	        
        </script>
    </form> 
</div>