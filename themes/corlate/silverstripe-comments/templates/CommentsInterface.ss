<% if CommentsEnabled %>
	<h1 id="comments_title">Kommentare</h1>
	<% if Comments %>
		<% loop Comments %>
			<% include CommentsInterface_singlecomment %>
		<% end_loop %>
	
		<% if Comments.MoreThanOnePage %>
			<div class="comments-pagination">
				<p>
					<% if Comments.PrevLink %>
						<a href="$Comments.PrevLink" class="previous">&laquo; <% _t('CommentsInterface_ss.PREV','previous') %></a>
					<% end_if %>
			
					<% if Comments.Pages %>
						<% loop Comments.Pages %>
							<% if CurrentBool %>
								<strong>$PageNum</strong>
							<% else %>
								<a href="$Link">$PageNum</a>
							<% end_if %>
						<% end_loop %>
					<% end_if %>

					<% if Comments.NextLink %>
						<a href="$Comments.NextLink" class="next"><% _t('CommentsInterface_ss.NEXT','next') %> &raquo;</a>
					<% end_if %>
				</p>
			</div>
		<% end_if %>
	<% end_if %>

	<p class="no-comments-yet"<% if $Comments.Count %> style='display: none' <% end_if %> ><% _t('CommentsInterface_ss.NOCOMMENTSYET','No one has commented on this page yet.') %></p>
		
	<% if ModeratedSubmitted %>
		<p id="$CommentHolderID_PostCommentForm_error" class="message good"><% _t('CommentsInterface_ss.AWAITINGMODERATION', 'Your comment has been submitted and is now awaiting moderation.') %></p>
	<% end_if %>
	
	<div id="contact-page clearfix">
           <div class="status alert alert-success" style="display: none"></div>
           <div class="message_heading">
               <h4>Hinerlasse einen Kommentar</h4>
               <p>Stelle sicher das alle Felder mit (*) ausgef&uuml;llt sind. HTML code ist nicht erlaubt.</p>
           </div> 
	
		$AddCommentForm
	
	</div>
	
<% end_if %>
	
