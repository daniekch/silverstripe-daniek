<% if $Tags %>
<div class="widget tags">
 	<h3>Tag Cloud</h3>
    <ul class="tag-cloud">
    	<% loop $Tags %>
        	<li><a class="btn btn-xs btn-primary" href="{$Link}" title="{$Title}">$Title</a></li>
        <% end_loop %>
     </ul>
 </div>
 <% end_if %>