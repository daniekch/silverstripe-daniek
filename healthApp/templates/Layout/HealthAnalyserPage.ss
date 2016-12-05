<% require javascript('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.bundle.min.js') %>
<% require css("themes/corlate/healthAnalyser/css/custom.css") %>

<section id="healthAnalyser">
	<div class="center">
		<h1>{$Title}</h1>
    	{$Content}
    </div>
    <div class="container">
    	<div class="row">
    		<div class="col-xs-12 col-sm-2">
    			<!-- <h3>Filter</h3>
	    		$SearchForm -->
	    		<p>Ihre Profilinformationen oder Datemimport des Apple Health XML k&ouml;nnen sie unter folgenden Link vornehmen:</p>
	    		<a href="$LinkToHealthProfilPage" title="Profil bearbeiten">Profil bearbeiten</a>
	    	</div>
	    	<div class="col-xs-12 col-sm-10">
		    	<div class="tab-wrap">
			        <div class="media">
			            <div class="parrent pull-left">
			                <ul class="nav nav-tabs nav-stacked">
			                	<% if $GetStepsValues %>
			  			        	<li class="active"><a href="#tab1" data-toggle="tab" class="analistic-01">Schritte</a></li>
			  			        <% end_if %>
			  			        <% if $GetDistanceValues %>
			  			        	<li><a href="#tab2" data-toggle="tab" class="analistic-02">Distanz</a></li>
			  			        <% end_if %>
			  			        <% if $GetClimbeValues %>
			  			        	<li><a href="#tab3" data-toggle="tab" class="analistic-03">H&ouml;he</a></li>
			  			        <% end_if %>
			  			        <% if $GetBodyMassValues %>
			  			        	<li><a href="#tab4" data-toggle="tab" class="analistic-04">Gewicht</a></li>
			                    <% end_if %>
			                    <% if $GetHearthRateValues %>
			                    	<li><a href="#tab5" data-toggle="tab" class="analistic-05">Puls</a></li>
			                    <% end_if %>
			                    <% if $GetBPDiastolicValues %>
			                    	<li><a href="#tab6" data-toggle="tab" class="analistic-06">Blutdruck</a></li>
								<% end_if %>
			                </ul>
			            </div>
						
		                <div class="parrent media-body">
		                    <div class="tab-content">
								<% if $GetStepsValues %>
					            	<!-- Steps -->
			                        <div class="tab-pane active" id="tab1">
										<canvas id="myStepsChart" width="400" height="400"></canvas>
										<script>
											var ctx = document.getElementById("myStepsChart");
											var myChart = new Chart(ctx, {
											    type: 'bar',
											    data: {
											        labels: [$GetStepsDateTime],
											        datasets: [{
											            label: 'Schritte',
											            fill: false,
											            backgroundColor: "rgba(197, 45, 47, 0.6)",
											            data: [$GetStepsValues]
											        }]
											    },
											    options: {
											    	legend: {
											    		display: false
											    	},
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
			                        <!-- End Steps -->
		                        <% end_if %>
		                        <% if $GetDistanceValues %>
			                  		<!-- Distance -->
			                        <div class="tab-pane" id="tab2">
										<canvas id="myDistanceChart" width="400" height="400"></canvas>
										<script>
											var ctx = document.getElementById("myDistanceChart");
											var myChart = new Chart(ctx, {
											    type: 'bar',
											    data: {
											        labels: [$GetDistanceDateTime],
											        datasets: [{
											            label: 'Kilometer',
											            fill: false,
											            backgroundColor: "rgba(197, 45, 47, 0.6)",
											            data: [$GetDistanceValues]
											        }]
											    },
											    options: {
											    	legend: {
											    		display: false
											    	},
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
			                        <!-- End Distance -->
								<% end_if %>
								<% if $GetClimbeValues %>
			                  		<!-- Climbing -->
			                        <div class="tab-pane" id="tab3">
										<canvas id="myClimbingChart" width="400" height="400"></canvas>
										<script>
											var ctx = document.getElementById("myClimbingChart");
											var myChart = new Chart(ctx, {
											    type: 'bar',
											    data: {
											        labels: [$GetClimbeDateTime],
											        datasets: [{
											            label: 'Kilometer',
											            fill: false,
											            backgroundColor: "rgba(197, 45, 47, 0.6)",
											            data: [$GetClimbeValues]
											        }]
											    },
											    options: {
											    	legend: {
											    		display: false
											    	},
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
			                        <!-- End Climbing -->
								<% end_if %>
								<% if $GetBodyMassValues %>
			                  		<!-- BodyMass -->
			                        <div class="tab-pane" id="tab4">
										<canvas id="myBodyMassChart" width="400" height="400"></canvas>
										<script>
											var ctx = document.getElementById("myBodyMassChart");
											var myChart = new Chart(ctx, {
											    type: 'bar',
											    data: {
											        labels: [$GetBodyMassDateTime],
											        datasets: [{
											            label: 'Kilometer',
											            fill: false,
											            backgroundColor: "rgba(197, 45, 47, 0.6)",
											            data: [$GetBodyMassValues]
											        }]
											    },
											    options: {
											    	legend: {
											    		display: false
											    	},
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
			                        <!-- End BodyMass -->
		                        <% end_if %>
		                        <% if $GetHearthRateValues %>
			                    	<!-- Heart Rate -->
			                        <div class="tab-pane" id="tab5">
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
											    	legend: {
											    		display: false
											    	},
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
									<!-- Heart Rate End -->
								<% end_if %>
								<% if $GetBPDiastolicValues %>
									<!-- Blood Presure -->
					                <div class="tab-pane" id="tab6">
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
										    	legend: {
										    		display: false
										    	},
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
											<% loop $CalcBPResult %>
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
					                <!-- Blood Presure End -->
		                        <% end_if %>
		                    </div>
		                </div>
		            </div> 
		        </div>
			</div>
    	</div>
	</div>
</section>