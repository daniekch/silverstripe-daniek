<% if $Archive %>
	<div class="widget archieve">
	    <h3>Archiv</h3>
	    <div class="row">
	        <div class="col-sm-12">
	            <ul class="blog_archieve">
	            	<% loop $Archive %>
	                	<li>
	                		<a href="{$Link}" title="{$Title}"><i class="fa fa-angle-double-right"></i> $Title</a>
	                	</li>
	                <% end_loop %>
	            </ul>
	        </div>
	    </div>                     
	</div>
<% end_if %>