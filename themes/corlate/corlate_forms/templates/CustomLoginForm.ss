<section id="contact-info">
	<div class="center">  
		<h2>Login</h2>
    	
	</div>
	<section id="contact-page">
		<div class="container">
	   		
			<div class="row contact-wrap">
				
			    <form id="main-contact-form" class="contact-form" $FormAttributes>
			        <div class="col-sm-6 col-sm-offset-3">
			        	<% if $IsRegistrationSuccessfully %>
					  		<div class="success">Ihre Registration war erfogreich. Bitte loggen Sie sich mit ihren Daten ein.</div>
					  	<% end_if %>
			            <div class="form-group">
			                <label>{$Fields.dataFieldByName(Email).Title}</label>
			                {$Fields.dataFieldByName(Email)}
			                <span id="{$FormName}_error" class="message {$Fields.dataFieldByName(Email).MessageType}">
					           {$Fields.dataFieldByName(Email).Message}
					       </span>
			            </div>
			            <div class="form-group">
			                <label>{$Fields.dataFieldByName(Password).Title}</label>
			                {$Fields.dataFieldByName(Password)}
			                <span id="{$FormName}_error" class="message {$Fields.dataFieldByName(Password).MessageType}">
					           {$Fields.dataFieldByName(Password).Message}
					       </span>
			            </div>
			            {$Fields.dataFieldByName(SecurityID)}
			            {$Fields.dataFieldByName(BackURL)}
			            {$Fields.dataFieldByName(AuthenticationMethod)}
			            <div class="form-group">
			            	<% loop $Actions %>$Field<% end_loop %>
			            </div>
			            <p>Haben Sie noch kein Login? <a href="{$BaseHref}registration" title="zur Registration">Zur Registration</a>.</p>
			        </div>
			    </form>
			</div>
		</div>
	</section>
</section>