<form id="health-login-form" class="health-login-form" $FormAttributes>
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
     <div class="form-group">
     	<% loop $Actions %>$Field<% end_loop %>
     </div>
</form> 