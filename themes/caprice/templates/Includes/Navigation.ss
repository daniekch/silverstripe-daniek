<div id="menu" class="menu-v">
	<% if $Menu(1) %>
		<ul>
			<% loop $Menu(1) %>
				<li>
					<a href="$Link" title="$Title.XML" class="<% if $LinkOrCurrent = current %>active<% end_if %>">$MenuTitle.XML</a>
					<% if $Children %>
						<ul>
							<% loop $Children %>
								<li><a href="$Link" title="$Title.XML" class="<% if $LinkOrCurrent = current %>active<% end_if %>">$MenuTitle.XML</a></li>
							<% end_loop %>
						</ul>
					<% end_if %>
				</li>
			<% end_loop %>
		</ul>
	<% end_if %>
</div>