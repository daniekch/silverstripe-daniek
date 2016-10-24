<form id="health-login-form" class="health-login-form" $FormAttributes>
     <div class="form-group">
         <label>{$Fields.dataFieldByName(FirstName).Title}</label>
         {$Fields.dataFieldByName(FirstName)}
         <span id="{$FormName}_error" class="message {$Fields.dataFieldByName(FirstName).MessageType}">
		    {$Fields.dataFieldByName(FirstName).Message}
		</span>
     </div>
     <div class="form-group">
         <label>{$Fields.dataFieldByName(Surname).Title}</label>
         {$Fields.dataFieldByName(Surname)}
	  	<span id="{$FormName}_error" class="message {$Fields.dataFieldByName(Surname).MessageType}">
			{$Fields.dataFieldByName(Surname).Message}
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