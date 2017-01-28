<ul class="nav navbar-nav">
	<% loop $Menu(1) %>
		
		<% if $LinkingMode == "Current" %>
			<li class="active">
		<% else_if $LinkingMode == "Section" %>
		    <li class="dropdown">
		<% else %>
		    <li>
		<% end_if %>
	    
		<% if $Children %>
			<a href="{$Link}" class="dropdown-toggle" data-toggle="dropdown">{$MenuTitle.XML} <i class="fa fa-angle-down"></i></a>
		    <ul class="dropdown-menu">
		      <% loop $Children %>
		        <li class="$LinkingMode">
		        	<a href="{$Link}">{$Title.XML}</a>
		        </li>
		      <% end_loop %>
		    </ul>
		<% else %>
			<a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
		<% end_if %>
			</li>
	<% end_loop %>                   
</ul>