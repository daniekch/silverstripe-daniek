<div class="widget tags">
 	<h3>Tag Cloud</h3>
    <ul class="tag-cloud">
    	<% loop TagsCollection %>
        	<li><a class="btn btn-xs btn-primary" href="{$Link}">$Tag.XML</a></li>
        <% end_loop %>
     </ul>
 </div>