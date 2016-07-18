<% require javascript('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.min.js') %>

<section id="healthAnalyser">
	<div class="center">
		<h1>{$Title}</h1>
    	{$Content}
    	
	</div>
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
	        }
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
		<tr><td>Type</td><td>Min</td><td>Avg</td><td>Max</td></tr>
		<% loop $CalResult %>
			<tr><td>$type</td><td>$min</td><td>$avg</td><td>$max</td></tr>
		<% end_loop %>
	</table>
</section>