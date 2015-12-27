<% require css("themes/corlate/sharePlace/css/style.css") %>
<% require javascript("themes/corlate/sharePlace/js/modernizr.js") %>
<% require javascript("themes/corlate/sharePlace/js/main.js") %>

<section id="sharePlace-info">
	<div class="center">
		<h1>{$Title}</h1>
    	{$Content}
    	<img src="themes/corlate/sharePlace/images/loading.svg" alt="Loading" id="imgLoading" style="display:none">
	</div>
	<section id="cd-timeline" class="cd-container" style="display:none">
		<script type="text/javascript">
			$("#imgLoading").fadeIn();
			$("#cd-timeline").load("{$Link}/getsharedplaces", function() {
				$("#imgLoading").remove();
				$("#cd-timeline").show();
				var moreButtonArea = $('#moreButtonArea').remove();
				moreButtonArea.appendTo('#sharePlace-info');
			});
		</script>
	</section>
</section>

