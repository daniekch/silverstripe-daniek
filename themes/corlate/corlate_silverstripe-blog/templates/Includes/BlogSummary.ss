<div class="blog-item">
    <div class="row">
        <div class="col-xs-12 col-sm-2 text-center">
            <div class="entry-meta">
                <span id="publish_date">{$Date.Long}</span>
                <span><i class="fa fa-user"></i> <a href="#">{$Author.XML}</a></span>
                <span><i class="fa fa-comment"></i> <a href="{$Link}#comments-holder" title="View Comments for this post">{$Comments.Count} <% _t('BlogSummary_ss.SUMMARYCOMMENTS','comment(s)') %></a></span>
                <span>
                	<i class="fa fa-heart"></i>
                	<% if TagsCollection %>
						<p class="tags">
							<% _t('BlogSummary_ss.TAGS','Tags') %>:
							<% loop TagsCollection %>
								<a href="$Link" title="View all posts tagged '$Tag'" rel="tag">$Tag</a><% if not Last %>,<% end_if %>
							<% end_loop %>
						</p>
					<% end_if %>
                </span>
            </div>
        </div>
            
        <div class="col-xs-12 col-sm-10 blog-content">
            <a href="#"><img class="img-responsive img-blog" src="images/blog/blog1.jpg" width="100%" alt="{$Title}" /></a>
            <h2><a href="{$Link}" title="<% _t('BlogSummary_ss.VIEWFULL', 'View full post titled -') %> '$Title'">{$MenuTitle}</a></h2>
            <h3><% if BlogHolder.ShowFullEntry %>$Content<% else %>$Content.FirstParagraph(html)<% end_if %></h3>
            <a class="btn btn-primary readmore" href="{$Link}" title="<% _t('BlogSummary_ss.VIEWFULL', 'View full post titled -') %> '$Title'">Read More <i class="fa fa-angle-right"></i></a>
        </div>
    </div>    
</div>