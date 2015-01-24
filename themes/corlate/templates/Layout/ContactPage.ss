<section id="contact-info">
	<div class="center">  
		<h2>{$Title}</h2>
    	{$Content}
	</div>
	<section id="contact-page">
		<div class="container">
	   		
	        <div class="row contact-wrap">
	       		<% if $Message %>
				    <div id="{$FormName}_error" class="status alert alert-success">{$Message}</div>
				<% else %>
				    <div id="{$FormName}_error" class="status alert alert-success" style="display: none"></div>
				<% end_if %>
		        <% if Success %>
					$SubmitText
				<% else %>
					{$ContactForm}
				<% end_if %>
			</div>
	    </div>
	</section>
</section>