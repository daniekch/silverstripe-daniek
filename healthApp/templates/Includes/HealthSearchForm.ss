<form id="health-search-form" class="health-search-form" $FormAttributes>
	<div class="form-group">
		<div id="Form_SearchForm_From_Holder" class="field date text">
			<label>{$Fields.dataFieldByName(From).Title}</label>
			<div class="middleColumn">
				{$Fields.dataFieldByName(From)}
			</div>
		</div>
		<div id="Form_SearchForm_To_Holder" class="field date text">
	       	<label>{$Fields.dataFieldByName(To).Title}</label>
	       	<div class="middleColumn">
	       		{$Fields.dataFieldByName(To)}
			</div>
		</div>
		{$Fields.dataFieldByName(SecurityID)}                     
		<div class="form-group">
			<% loop $Actions %>$Field<% end_loop %>
		</div>
	</div>
</form>

<% require javascript("framework/thirdparty/jquery-ui/jquery-ui.js") %>
<% require javascript("framework/thirdparty/jquery-ui/datepicker/i18n/jquery.ui.datepicker-de.js") %>
<% require javascript("framework/javascript/DateField.js") %>
<% require css("framework/thirdparty/jquery-ui-themes/smoothness/jquery-ui.css") %>