<% require javascript('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js') %>

<section id="feature" class="transparent-bg">
    <div class="container">
		<div class="center">
			<h1>{$Title}</h1>
	    	<% if not $Authorized %><p class="lead">{$Content}</p><% end_if %>
	    </div>
	    <% if $Authorized %>
	    	<div class="row">
	    		<div class="col-xs-12 col-sm-3">
	    			<h2>Profil</h2>
	    			<address>
	    				<img alt="Avatar" src="{$AvatarURL}" />
	    				<p>
	    					{$DisplayName}<br />
	    					{$Birthday}
	    				</p>
	    			</address>
	    			<hr />
   					<% loop $GetDevices %>
				        Geraet: {$deviceVersion}<br />
				        Batterie: {$battery}<br />
				        Letzte Synchronisierung: {$lastSyncTime}
		    		<% end_loop %>
	    			<hr />
	    			<a href="{$BaseURL}api/fitbit/revoke?backURL={$Link}" title="Abmelden">Abmelden</a>
	    			<hr />
	    			<a href="{$Link}?forcerefresh=1"><img alt="Refresh" src="themes/corlate/images/refresh_icon.png" width="30" height="30"></a>
	    		</div>
	    		<div class="col-xs-12 col-sm-6 text-center">
	    			<h2>Aktivit&auml;ten vom {$Now.Format('d.m.Y')}</h2>
	    			
					<canvas id="myChart" width="100" height="100"></canvas>
					<script>
					var ctx = document.getElementById("myChart");
					var data = {
						    labels: [
						        "Heute",
						        "verbleibend bis Ziel"
						    ],
						    datasets: [
						        {
						            data: [$Steps, $RemainToGoal],
						            backgroundColor: [
										"#4BC0C0",
						                "#FF6384"
						            ],
						            hoverBackgroundColor: [
										"#4BC0C0",
						                "#FF6384"
						            ]
						        }]
						};
					var myDoughnutChart = new Chart(ctx, {
					    type: 'doughnut',
					    data: data
					});
					</script>
					
					<i>Durchschnitt pro Tag: {$AverageDailySteps} Schritte</i>
					
				</div>
				<div class="col-xs-12 col-sm-3">
	    			<h2>Auszeichnungen</h2>
	    			<% loop $Badges %>
				        <div class="single_comments">
	                        <img src="{$imageURL75px}" alt="Bages">
	                        <p>{$marketingDescription}</p>
	                    </div>
				    <% end_loop %>
	    		</div>
			</div>
		<% else %>
			<div class="row">
	            <div class="features">
	                <div class="col-md-4 col-sm-6">
	                    <div class="feature-wrap">
	                        <h2>{$Column_1_title}</h2>
	                        <p>{$Column_1_desc}</p>
	                    </div>
	                </div>
	
	                <div class="col-md-4 col-sm-6">
	                    <div class="feature-wrap">
	                        {$Column_2_img.SetWidth(300)}
	                    </div>
	                </div>
	
	                <div class="col-md-4 col-sm-6ow">
	                    <div class="feature-wrap">
	                        <h2>{$Column_3_title}</h2>
	                        <p>{$Column_3_desc}</p>
	                    </div>
	                </div>
	            </div>
	        </div>
	    	<div class="row">
	    		<div class="col-xs-12 col-sm-12 text-center">
	    			<% with $ErrorMessage %>
			            <p class="{$cssClass}">{$message}</p>
			        <% end_with %>
					<a href="{$Link}Authorization" title="Anmelden" class="btn btn-primary btn-lg">Anmelden</a>
				</div>
			</div>
			
		<% end_if %>
	</div>
</section>