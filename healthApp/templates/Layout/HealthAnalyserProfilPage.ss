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
		    	<% if $CurrentMember %>
		    		<p>{$HealthData_Desc}</p>
		    		<table>
		    			<tr>
		    				<th>Type</th>
		    				<th>Anzahl</th>
		    			</tr>
		    			<% if $StepsCount %>
			    			<tr>
			    				<td>Schritte</td>
			    				<td>$StepsCount</td>
			    			</tr>
		    			<% end_if %>
		    			<% if $DistanceCount %>
			    			<tr>
			    				<td>Distanz</td>
			    				<td>$DistanceCount</td>
			    			</tr>
		    			<% end_if %>
		    			<% if $ClimbingCount %>
			    			<tr>
			    				<td>H&ouml;he</td>
			    				<td>$ClimbingCount</td>
			    			</tr>
		    			<% end_if %>
		    			<% if $BodyMassCount %>
			    			<tr>
			    				<td>Gewicht</td>
			    				<td>$BodyMassCount</td>
			    			</tr>
		    			<% end_if %>
		    			<% if $HearthRateCount %>
			    			<tr>
			    				<td>Puls</td>
			    				<td>$HearthRateCount</td>
			    			</tr>
		    			<% end_if %>
		    			<% if $BPSystolicCount %>
			    			<tr>
			    				<td>Blutdruck (Systolic)</td>
			    				<td>$BPSystolicCount</td>
			    			</tr>
		    			<% end_if %>
		    			<% if $BPDiastolicCount %>
			    			<tr>
			    				<td>Blutdruck (Diastolic)</td>
			    				<td>$BPDiastolicCount</td>
			    			</tr>
		    			<% end_if %>
		    		</table>
		    		<h2>{$HealthImport_Title}</h2>
		    		<p>{$HealthImport_Desc}</p>
			    	$ImportForm
		      	<% else %>
		      		Sie m&uuml;ssen eingeloggt sein um Daten importieren oder sehen zu k&ouml;nnen.
		        <% end_if %>
			</div>
    	</div>
	
	</div>
</section>