<section id="blog" class="container">
    <div class="center">
        <h2>{$Title}</h2>
    </div>

    <div class="blog">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-item">
                	<% if $HeadImage %>
						<% with $HeadImage %>
							<img class="img-responsive img-blog" src="{$URL}" width="100%" alt="{$Up.Title}" />
						<% end_with %>
					<% end_if %>
                    <div class="row">  
                        <div class="col-xs-12 col-sm-2 text-center">
                            <div class="entry-meta">
                                <span id="publish_date">{$Date.DayOfMonth} {$Date.ShortMonth}</span>
                                <span><i class="fa fa-comment"></i> <a href="{$Link}#comments-holder" title="View Comments for this post">{$Comments.Count} <% _t('BlogSummary_ss.SUMMARYCOMMENTS','comment(s)') %></a></span>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 blog-content">
                        	<% if TagsCollection %>
								<div class="post-tags">
									<strong><% _t('BlogSummary_ss.TAGS','Tags') %></strong> 
									<% loop TagsCollection %>
										<a href="{$Link}" title="View all posts tagged '$Tag'">$Tag</a><% if not Last %> / <% end_if %>
									<% end_loop %>
								</div>
							<% end_if %>
                            $Content
                        </div>
                    </div>
                </div>
                
                $PageComments
                
            </div>
			
            <aside class="col-md-4">
            	<% include BlogSideBar %>
            </aside>     
        </div>
     </div>
</section>

