<div class="widget categories">
    <h3>letzte Kommentare</h3>
    <div class="row">
        <div class="col-sm-12">
        	<% loop Comments %>
	            <div class="single_comments">
	                <img src="{$ThemeDir}/images/blog/avatar3.png" alt="">
	                <p>{$Comment}</p>
	                <div class="entry-meta small muted">
                        <span>Von <a href="#">{$Name}</a></span>in <a href="{$Link}">{$ParentTitle}</a>
	                </div>
	            </div>
            <% end_loop %>
        </div>
    </div>                     
</div>