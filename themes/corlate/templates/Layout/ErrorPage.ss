<section id="error" class="container text-center">
	<h1>{$ErrorCode}, <% if $ErrorCode == 404 %>Seite nicht gefunden<% else %>Fehler aufgetreten<% end_if %></h1>
	$Content
	<a class="btn btn-primary" href="{$baseHref}">ZUR&Uuml;CK ZUR STARTSEITE</a>
</section>