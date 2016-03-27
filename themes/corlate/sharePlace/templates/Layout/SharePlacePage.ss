<% require css("themes/corlate/sharePlace/css/style.css") %>
<% require css("themes/corlate/sharePlace/css/custom.css") %>
<% require javascript("themes/corlate/sharePlace/js/modernizr.js") %>
<% require javascript("themes/corlate/sharePlace/js/main.js") %>
<% require javascript("themes/corlate/sharePlace/js/custom.js") %>

<section id="sharePlace-info">
	<div class="center">
		<h1>{$Title}</h1>
    	{$Content}
    	<p><a href="#" title="Beitrag erfassen" id="btnNewPost" class="btn btn-primary btn-lg">Beitrag erfassen</a></p>
    	<img src="themes/corlate/sharePlace/images/loading.svg" alt="Loading" id="imgLoading" style="display:none">
    	$SharePlaceUploadForm
	</div>
	<section id="cd-timeline" class="row cd-container" style="display:none">
		<script type="text/javascript">
			jQuery(document).ready(function($){
				initShareplaces("{$Link}");
			});
		</script>
	</section>
</section>

