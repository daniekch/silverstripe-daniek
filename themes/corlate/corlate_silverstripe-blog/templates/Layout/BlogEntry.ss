<section id="blog" class="container">
    <div class="center">
        <h2>{$Title}</h2>
        <p class="lead">{$Content}</p>
    </div>

    <div class="blog">
        <div class="row">
            <div class="col-md-8">
                <div class="blog-item">
                <img class="img-responsive img-blog" src="images/blog/blog1.jpg" width="100%" alt="" />
                    <div class="row">  
                        <div class="col-xs-12 col-sm-2 text-center">
                            <div class="entry-meta">
                                <span id="publish_date">{$Date.DayOfMonth} {$Date.ShortMonth}</span>
                                <span><i class="fa fa-comment"></i> <a href="{$Link}#comments-holder" title="View Comments for this post">{$Comments.Count} <% _t('BlogSummary_ss.SUMMARYCOMMENTS','comment(s)') %></a></span>
                                
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-10 blog-content">
                            $Content
                            <% if TagsCollection %>
					<div class="post-tags">
						<strong><% _t('BlogSummary_ss.TAGS','Tags') %></strong> 
						<% loop TagsCollection %>
							<a href="{$Link}" title="View all posts tagged '$Tag'">$Tag</a><% if not Last %> / <% end_if %>
						<% end_loop %>
					</div>
				<% end_if %>
                        </div>
                    </div>
                </div>
                
                $PageComments
                
                <h1 id="comments_title">5 Comments</h1>
                <div class="media comment_section">
                    <div class="pull-left post_comments">
                        <a href="#"><img src="images/blog/girl.png" class="img-circle" alt="" /></a>
                    </div>
                    <div class="media-body post_reply_comments">
                        <h3>Marsh</h3>
                        <h4>NOVEMBER 9, 2013 AT 9:15 PM</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
                        <a href="#">Reply</a>
                    </div>
                </div> 
                <div class="media comment_section">
                    <div class="pull-left post_comments">
                        <a href="#"><img src="images/blog/boy2.png" class="img-circle" alt="" /></a>
                    </div>
                    <div class="media-body post_reply_comments">
                        <h3>Marsh</h3>
                        <h4>NOVEMBER 9, 2013 AT 9:15 PM</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
                        <a href="#">Reply</a>
                    </div>
                </div> 
                <div class="media comment_section">
                    <div class="pull-left post_comments">
                        <a href="#"><img src="images/blog/boy3.png" class="img-circle" alt="" /></a>
                    </div>
                    <div class="media-body post_reply_comments">
                        <h3>Marsh</h3>
                        <h4>NOVEMBER 9, 2013 AT 9:15 PM</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud</p>
                        <a href="#">Reply</a>
                    </div>
                </div> 


                <div id="contact-page clearfix">
                    <div class="status alert alert-success" style="display: none"></div>
                    <div class="message_heading">
                        <h4>Leave a Replay</h4>
                        <p>Make sure you enter the(*)required information where indicate.HTML code is not allowed</p>
                    </div> 

                    <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="sendemail.php" role="form">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label>Name *</label>
                                    <input type="text" class="form-control" required="required">
                                </div>
                                <div class="form-group">
                                    <label>Email *</label>
                                    <input type="email" class="form-control" required="required">
                                </div>
                                <div class="form-group">
                                    <label>URL</label>
                                    <input type="url" class="form-control">
                                </div>                    
                            </div>
                            <div class="col-sm-7">                        
                                <div class="form-group">
                                    <label>Message *</label>
                                    <textarea name="message" id="message" required="required" class="form-control" rows="8"></textarea>
                                </div>                        
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg" required="required">Submit Message</button>
                                </div>
                            </div>
                        </div>
                    </form>     
                </div>
            </div>

            <aside class="col-md-4">
            	<% include BlogSideBar %>
            </aside>     
        </div>
     </div>
</section>

