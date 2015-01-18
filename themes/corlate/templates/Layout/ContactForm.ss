<div class="row contact-wrap">
	<% if $Message %>
	    <div id="{$FormName}_error" class="status alert alert-success">{$Message}</div>
	<% else %>
	    <div id="{$FormName}_error" class="status alert alert-success" style="display: none"></div>
	<% end_if %>
      
    <form id="main-contact-form" class="contact-form" $FormAttributes>
        <div class="col-sm-5 col-sm-offset-1">
            <div class="form-group">
                <label>{$Fields.dataFieldByName(Name).Title}</label>
                {$Fields.dataFieldByName(Name)}
                <span id="{$FormName}_error" class="message {$Fields.dataFieldByName(Name).MessageType}">
		           {$Fields.dataFieldByName(Name).Message}
		       </span>
            </div>
            <div class="form-group">
                <label>{$Fields.dataFieldByName(Email).Title}</label>
                {$Fields.dataFieldByName(Email)}
		        <span id="{$FormName}_error" class="message {$Fields.dataFieldByName(Email).MessageType}">
		           {$Fields.dataFieldByName(Email).Message}
		       </span>
            </div>
			<div class="form-group">
			    <label>{$Fields.dataFieldByName(Phone).Title}</label>
			    {$Fields.dataFieldByName(Phone)}
			    <span id="{$FormName}_error" class="message {$Fields.dataFieldByName(Phone).MessageType}">
		       		{$Fields.dataFieldByName(Phone).Message}
		       	</span>
			</div>
	        <div class="form-group">
		        <label>{$Fields.dataFieldByName(Company).Title}</label>
			    {$Fields.dataFieldByName(Company)}
			    <span id="{$FormName}_error" class="message {$Fields.dataFieldByName(Company).MessageType}">
		       		{$Fields.dataFieldByName(Company).Message}
		       	</span>
		    </div>                        
		</div>
		<div class="col-sm-5">
            <div class="form-group">
                <label>{$Fields.dataFieldByName(Subject).Title}</label>
                {$Fields.dataFieldByName(Subject)}
                <span id="{$FormName}_error" class="message {$Fields.dataFieldByName(Subject).MessageType}">
		           {$Fields.dataFieldByName(Subject).Message}
		       </span>
            </div>
            <div class="form-group">
                <label>{$Fields.dataFieldByName(Comments).Title}</label>
                {$Fields.dataFieldByName(Comments)}
                <span id="{$FormName}_error" class="message {$Fields.dataFieldByName(Comments).MessageType}">
		           {$Fields.dataFieldByName(Comments).Message}
		       </span>
            </div>
            {$Fields.dataFieldByName(SecurityID)}                     
            <div class="form-group">
            	<% loop $Actions %>$Field<% end_loop %>
            </div>
        </div>
    </form> 
</div>