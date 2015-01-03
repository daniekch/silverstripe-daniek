<div class="widget archieve">
    <h3>Archiv</h3>
    <div class="row">
        <div class="col-sm-12">
            <ul class="blog_archieve">
            	<% loop Dates %>
                	<li>
                		<a href="{$Link}"><i class="fa fa-angle-double-right"></i><% if $Up.DisplayMode == month %> {$Date.Format(F)} {$Date.Year} <% else %> {$Date.Year}<% end_if %></a>
                	</li>
                <% end_loop %>
            </ul>
        </div>
    </div>                     
</div>