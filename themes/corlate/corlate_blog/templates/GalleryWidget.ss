<div class="widget blog_gallery">
    <h3>Bilder Gallerie</h3>
    <ul class="sidebar-gallery">
		<% loop Gallery %>
			<li><a href="{$ImageHref}" rel="prettyPhoto[blog_gallery]" title="{$Title}"><img src="{$ThumbHref}" alt="{$Title}"></a></li>
		<% end_loop %>
	</ul>
</div>