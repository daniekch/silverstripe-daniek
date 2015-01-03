<section id="blog" class="container">
    <div class="center">
        <h2>{$Title}</h2>
        <p class="lead">{$Content}</p>
    </div>

    <div class="blog">
        <div class="row">
             <div class="col-md-8">
             
             	<% include BreadCrumbs %>
	
				<% if SelectedTag %>
					<h3><% _t('BlogHolder_ss.VIEWINGTAGGED', 'Viewing entries tagged with') %> '$SelectedTag'</h3>
				<% else_if SelectedDate %>
					<h3><% _t('BlogHolder_ss.VIEWINGPOSTEDIN', 'Viewing entries posted in') %> $SelectedNiceDate</h3>
				<% else_if SelectedAuthor %>
					<h3><% _t('BlogHolder_ss.VIEWINGPOSTEDBY', 'Viewing entries posted by') %> $SelectedAuthor</h3>
				<% end_if %>
             
            	<% if BlogEntries %>
					<% loop BlogEntries %>
						<% include BlogSummary %>
					<% end_loop %>
				<% else %>
					<h2><% _t('BlogHolder_ss.NOENTRIES', 'There are no blog entries') %></h2>
				<% end_if %>
				
                <% include BlogPagination %>
                
            </div>

            <aside class="col-md-4">
            
            	<% include BlogSideBar %>
            
			</aside>  
        </div>
    </div>
</section>
