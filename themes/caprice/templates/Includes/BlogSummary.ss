<div class="post">
	<a href="post.html"><img src="style/images/art/slide1.jpg" alt="" /></a>

	<div class="info">
	
	<div class="date">
		<div class="day">$Date.Day</div>
		<div class="month">$Date.Month</div>
	</div>
	
	<div class="meta">
		<h3 class="title"><a href="{$Link}" title="{$Title}">$MenuTitle</a></h3>
		<div class="comments"><a href="#">{$Comments.Count} Kommentare</a></div>
		<div class="tags">
			<% loop TagsCollection %>
				<a href="$Link">$Tag</a><% if not Last %>, <% end_if %>
			<% end_loop %>
		</div>
	</div>
	
	</div>
	<div class="clear"></div>
	
	<p>
		<% if BlogHolder.ShowFullEntry %>
			$Content
		<% else %> 
			<p>$Content.FirstParagraph(html)</p>
		<% end_if %>
	</p>

</div>