<% require css("themes/corlate/healthAnalyser/css/custom.css") %>

<section id="health-profil" class="transparent-bg">

    <div class="container">
    	<div class="center">
			<h1>{$Title}</h1>
		   	{$Content}
		   	<a href="{$BaseHref}/outdoor/health-app/health-analyser" class="action btn btn-primary btn-lg">Zur&uuml;ck zum Health Analyser</a>
		</div>
    	<div class="row">
    		<div class="col-xs-12 col-sm-5">
    			<% if $CurrentMember %>
    				<% if $IsEdit %>
		    			<h2>Personalien bearbeiten</h2>
		    			$EditForm
		    		<% else %>
			   			<h2>Ihre Personalien</h2>
			            Vorname: {$CurrentMember.FirstName} <br />
			            Name: {$CurrentMember.Surname} <br /><br />
			            <a href="{$Link}?edit=1" title="Profil bearbeiten">Profil bearbeiten</a>
					<% end_if %>
				<% else %>
	    			<% if $IsRegistration %>
	    				<h2>Registration</h2>
	    				<p>Bitte registrieren sie sich mit dem Formular.</p>
		    			$RegisterForm
		    			zur&uuml;ck zum <a href="{$Link}" title="zur&uuml;ck zum Login">Login</a>
		    		<% else %>
		    			<h2>Login</h2>
		    			<p>Bitte loggen sie sich mit ihrem Account ein.</p>
	    				$LoginForm
	    				<p>Noch kein Login? Dann k&ouml;nnen sie sich <a href="{$Link}?registration=1" title="Registration Health Analyser">hier</a> registrieren.</p>
	    			<% end_if %>
	    		<% end_if %>
		    </div>
	    	<div class="col-xs-12 col-sm-6">
	    		<h2>{$HealthData_Title}</h2>
		    	<% if $HasHealthData %>
		    		<p>{$HealthData_Desc}</p>
		    		<table>
		    			<tr>
		    				<th>Type</th>
		    				<th>Anzahl</th>
		    			</tr>
		    			<tr>
		    				<td>Schritte</td>
		    				<td><% if $StepsCount %>$StepsCount<% else %><i>keine Daten</i><% end_if %></td>
		    			</tr>
		    			<tr>
		    				<td>Distanz</td>
		    				<td><% if $DistanceCount %>$DistanceCount<% else %><i>keine Daten</i><% end_if %></td>
		    			</tr>
		    			<tr>
		    				<td>H&ouml;he</td>
		    				<td><% if $ClimbingCount %>$ClimbingCount<% else %><i>keine Daten</i><% end_if %></td>
		    			</tr>
		    			<tr>
		    				<td>Gewicht</td>
		    				<td><% if $BodyMassCount %>$BodyMassCount<% else %><i>keine Daten</i><% end_if %></td>
		    			</tr>
		    			<tr>
		    				<td>Puls</td>
		    				<td><% if $HearthRateCount %>$HearthRateCount<% else %><i>keine Daten</i><% end_if %></td>
		    			</tr>
		    			<tr>
		    				<td>Blutdruck (Systolic)</td>
		    				<td><% if $BPSystolicCount %>$BPSystolicCount<% else %><i>keine Daten</i><% end_if %></td>
		    			</tr>
		    			<tr>
		    				<td>Blutdruck (Diastolic)</td>
		    				<td><% if $BPDiastolicCount %>$BPDiastolicCount<% else %><i>keine Daten</i><% end_if %></td>
		    			</tr>
		    		</table>
		    	<% else %>
		      		<i>Sie haben noch keine Daten importiert.</i>
		        <% end_if %>
	    		<h2>{$HealthImport_Title}</h2>
	    		<p>{$HealthImport_Desc}</p>
		    	$ImportForm
			</div>
    	</div>
	</div>
</section>