<% if $IncludeFormTag %>
<form class="contact-form" {$AttributesHTML}>
<% end_if %>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	
	<div class="row">
		<div class="">
			<% loop $Fields %>
				$FieldHolder
			<% end_loop %>
	
			<% if $Actions %>
				<% loop $Actions %>
					$Field
				<% end_loop %>
			<% end_if %>
		</div>
	</div>
<% if $IncludeFormTag %>
</form>
<% end_if %>