<% if BlogEntries.MoreThanOnePage %>
	<ul class="pagination pagination-lg">
		<% if BlogEntries.NotFirstPage %>
			<li>
				<a href="{$BlogEntries.PrevLink}" title="View the previous page"><i class="fa fa-long-arrow-left"></i>Previous Page</a>
			</li>
		<% end_if %>
		
		<% loop BlogEntries.PaginationSummary(4) %>
			<% if CurrentBool %>
				<li class="active"><a href="#">{$PageNum}</a></li>
			<% else %>
				<% if Link %>
					<li>
						<li><a href="{$Link}">{$PageNum}</a></li>
					</li>
				<% else %>
					<li><a href="#">{$PageNum}</a></li>
				<% end_if %>
			<% end_if %>
		<% end_loop %>
		
		<% if BlogEntries.NotLastPage %>
			<li><a href="{$BlogEntries.NextLink}" title="View the next page">Next Page<i class="fa fa-long-arrow-right"></i></a></li>
		<% end_if %>
	</ul>
<% end_if %>

