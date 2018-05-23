<% require css("canopusHA/css/toggle-switch.css") %>
<% require css("canopusHA/css/canopusha.css") %>
<% require javascript("canopusHA/js/canopusha.js") %>

<section id="feature" class="transparent-bg">
    <div class="container">
		<div class="center">
			<h1>{$Title}</h1>
	    </div>
	    <div class="row">
    		<div class="col-xs-12 col-sm-5">
    			<label class="switch-light switch-candy">
					<input type="checkbox" id="inptSwitch" {$LightStatus} />
			  		<strong>Licht</strong>
			  		<span>
					    <span>Off</span>
					    <span>On</span>
					    <a></a>
					</span>
				</label>
		    </div>
	    	<div class="col-xs-12 col-sm-6">
	    		{$GetWebcamImage}
	    		<h2>Info</h2>
		    	<table>
		    		<tr>
		    			<td>IP</td>
		    			<td><i>{$GetIP}</i></td>
		    		</tr>
		    		<tr>
		    			<td>SSH Port</td>
		    			<td><i>{$GetSSLPort}</i></td>
		    		</tr>
		    		<tr>
		    			<td>Socket Port</td>
		    			<td><i>{$GetSocketPort}</i></td>
		    		</tr>
		    		<tr>
		    			<td>Letze Aktualisierung</td>
		    			<td><i>{$LastModified}</i></td>
		    		</tr>
		    	</table>
			</div>
    	</div>
	</div>
</section>