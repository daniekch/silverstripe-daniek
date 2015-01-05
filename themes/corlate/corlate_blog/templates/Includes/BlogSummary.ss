<div class="blog-item">
    <div class="row">
        <div class="col-xs-12 col-sm-2 text-center">
            <div class="entry-meta">
                <span id="publish_date">{$Date.DayOfMonth} {$Date.ShortMonth}</span>
                <span><i class="fa fa-comment"></i> <a href="{$Link}#comments-holder" title="KOmmentare zu diesem Blog">{$Comments.Count} Kommentare</a></span>
               	<% if TagsCollection %>
					<span>
						<i><% _t('BlogSummary_ss.TAGS','Tags') %></i> 
						<% loop TagsCollection %>
							<a href="$Link" title="View all posts tagged '$Tag'" rel="tag">$Tag</a><% if not Last %>,<% end_if %>
						<% end_loop %>
					</span>
				<% end_if %>
            </div>
        </div>
            
        <div class="col-xs-12 col-sm-10 blog-content">
      	    <% if $HeadImage %>
				<% with $HeadImage %>
					<a href="{$Up.Link}"><img class="img-responsive img-blog" src="{$URL}" width="100%" alt="{$Up.Title}" /></a>
				<% end_with %>
			<% end_if %>
            <h2><a href="{$Link}" title="<% _t('BlogSummary_ss.VIEWFULL', 'View full post titled -') %> '$Title'">{$MenuTitle}</a></h2>
            <h3><% if BlogHolder.ShowFullEntry %>$Content<% else %>$Content.FirstParagraph(html)<% end_if %></h3>
            <a class="btn btn-primary readmore" href="{$Link}" title="<% _t('BlogSummary_ss.VIEWFULL', 'View full post titled -') %> '$Title'">Read More <i class="fa fa-angle-right"></i></a>
        </div>
    </div>    
</div>