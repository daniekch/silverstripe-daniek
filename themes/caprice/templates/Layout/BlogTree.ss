<h1 class="title">{$Title}</h1>
<div class="line"></div>
<div class="intro">$Content</div>

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
	<h2><% _t('BlogTree_ss.NOENTRIES', 'There are no blog entries') %></h2>
<% end_if %>


<% include BlogPagination %>
		
	<!-- Begin Footer -->
    <div id="footer">
  	<div class="footer-box one-third">
  	<h3>Popular Posts</h3>
			<ul class="popular-posts">
				<li>
					<a href="#"><img src="style/images/art/s1.jpg" alt="" /></a>
					<h5><a href="#">Dolor Commodo Consectetur</a></h5>
					<span>26 Aug 2011 | <a href="#">21 Comments</a></span>
				</li>
				
				<li>
					<a href="#"><img src="style/images/art/s2.jpg" alt="" /></a>
					<h5><a href="#">Dolor Commodo Consectetur</a></h5>
					<span>26 Aug 2011 | <a href="#">21 Comments</a></span>
				</li>
				
				<li>
					<a href="#"><img src="style/images/art/s3.jpg" alt="" /></a>
					<h5><a href="#">Dolor Commodo Consectetur</a></h5>
					<span>26 Aug 2011 | <a href="#">21 Comments</a></span>
				</li>

			</ul>
  	</div>
  	<div class="footer-box one-third">
  	<h3>About</h3>
  	<p>Donec id elit non mi porta gravida at eget metus. Donec ullamcorper nulla non metus auctor fringilla.</p> 
  	<p>Lorem Ipsum Dolor Sit
          Moon Avenue No:11/21
          Planet City, Earth<br>
          <br>
          <span class="lite1">Fax:</span> +555 797 534 01<br>
          <span class="lite1">Tel:</span> +555 636 646 62<br>
          <span class="lite1">E-mail:</span> name@domain.com</p>
          
          
  	</div>
  	
  	<div class="footer-box one-third last">
  	<h3>Custom Text</h3>
  	<p>Nullam quis risus eget urna mollis ornare vel eu leo. Maecenas faucibus mollis interdum. Etiam porta sem malesuada magna mollis euismod. Nulla vitae elit. </p>
  	<p>Donec ullamcorper nulla non metus auctor fringilla. Maecenas faucibus mollis interdum. Curabitur blandit tempus porttitor.</p>
  	</div>
    </div>
    <!-- End Footer -->
		
		
	</div>