<% require javascript('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.min.js') %>
<% require css("themes/corlate/healthAnalyser/css/custom.css") %>

<section id="healthAnalyser">
	<div class="center">
		<h1>{$Title}</h1>
    	{$Content}
    </div>
    <div class="container">
    	<div class="row">
    		<div class="col-xs-12 col-sm-2">
    			<h3>Filter</h3>
	    		$SearchForm
	    		<p>Ihre Profilinformationen oder Datemimport des Apple Health XML k&ouml;nnen sie unter folgenden Link vornehmen:</p>
	    		<a href="outdoor/health-analyser/profil-informationen?healthAppUrl={$getEncodedHealthAppURL}" title="Profil bearbeiten">Profil bearbeiten</a>
	    	</div>
	    	<div class="col-xs-12 col-sm-10">
		    	<div class="tab-wrap">
			        <div class="media">
			            <div class="parrent pull-left">
			                <ul class="nav nav-tabs nav-stacked">
			                    <li class="active"><a href="#tab1" data-toggle="tab" class="analistic-01">Puls</a></li>
			                    <li class=""><a href="#tab2" data-toggle="tab" class="analistic-02">Blutdruck</a></li>
			                </ul>
			            </div>
		
		                <div class="parrent media-body">
		                    <div class="tab-content">
		                        <div class="tab-pane active" id="tab1">
									<canvas id="myHeartRateChart" width="400" height="400"></canvas>
									<script>
										var ctx = document.getElementById("myHeartRateChart");
										var myChart = new Chart(ctx, {
										    type: 'line',
										    data: {
										        labels: [$GetHearthRateDateTime],
										        datasets: [{
										            label: 'Herzfrequenz',
										            fill: false,
										            borderColor: "rgb(204, 51, 0)",
										            data: [$GetHearthRateValues]
										        }]
										    },
										    options: {
										    	responsive: true,
										    	scales: {
										            yAxes: [{
										                ticks: {
										                    beginAtZero:true
										                }
										            }]
										        }
										    }
										});
									</script>
		                        </div>
		
		                         <div class="tab-pane" id="tab2">
		                         	<canvas id="myBPChart" width="400" height="400"></canvas>
									<script>
									var ctx = document.getElementById("myBPChart");
									var myChart = new Chart(ctx, {
									    type: 'line',
									    data: {
									        labels: [$GetBPDateTime],
									        datasets: [{
									            label: 'Systolic',
									            fill: false,
									            borderColor: "rgb(204, 51, 0)",
									            data: [$GetBPSystolicValues]
									        },
									        {
									            label: 'Default Systolic',
									            fill: false,
									            borderWidth: 1,
									            pointRadius: 0,
									            borderColor: "rgb(204, 51, 0)",
									            data: [$GetBPSystolicDefault]
									        },
									        {
									            label: 'Diastolic',
									            fill: false,
									            borderColor: "rgb(153, 153, 255)",
									            data: [$GetBPDiastolicValues]
									        },
									        {
									            label: 'Default Diastolic',
									            fill: false,
									            borderWidth: 1,
									            pointRadius: 0,
									            borderColor: "rgb(153, 153, 255)",
									            data: [$GetBPDiastolicDefault]
									        }],
									    },
									    options: {
									    	responsive: true,
									    	scales: {
									            yAxes: [{
									                ticks: {
									                    beginAtZero:true
									                }
									            }]
									        }
									    }
									});
									</script>
					
									<table>
										<tr><td>Type</td><td>Min</td><td>Avg</td><td>Max</td><td>Over percent</td></tr>
										<% loop $CalResult %>
											<tr>
												<td>$type</td>
												<td>$min mmHg</td>
												<td>$avg mmHg</td>
												<td>$max mmHg</td>
												<td>$percentOver %</td>
											</tr>
										<% end_loop %>
									</table>
		                         </div>
		                       
		                    </div>
		                </div>
		            </div> 
		        </div>
			</div>
    	</div>
	</div>
</section>