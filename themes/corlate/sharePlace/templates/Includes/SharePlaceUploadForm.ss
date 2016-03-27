<div class="container contact-wrap" style="display: none;" id="uploadForm">
	<% if $Message %>
	    <div id="{$FormName}_error" class="status alert alert-success">{$Message}</div>
	<% else %>
	    <div id="{$FormName}_error" class="status alert alert-success" style="display: none"></div>
	<% end_if %>
      
    <form id="main-contact-form" class="contact-form" $FormAttributes>
    	<div class="row">
	        <div class="col-sm-5">
	        	<div class="form-group">
	                <label>{$Fields.dataFieldByName(ShareType).Title}</label>
	                {$Fields.dataFieldByName(ShareType)}
	            </div>
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
	            {$Fields.dataFieldByName(NearBy)}
	            {$Fields.dataFieldByName(NearByIcon)}
	            {$Fields.dataFieldByName(SecurityID)}                     
	            <div class="form-group">
	            	<% loop $Actions %>$Field<% end_loop %>
	            </div>
	        </div>
        </div>
        <div id="temp-map"></div>
        <script type="text/javascript">
        	jQuery(document).ready(function($){
        		setGeoLocation();
        	});
        </script>
    </form> 
</div>