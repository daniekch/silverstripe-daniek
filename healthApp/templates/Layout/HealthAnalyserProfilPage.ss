<% require css("themes/corlate/healthAnalyser/css/custom.css") %>

<section id="health-profil" class="transparent-bg">

    <div class="container">
    	<div class="center">
			<h1>{$Title}</h1>
		   	{$Content}
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
		    		<% else %>
		    			<h2>Login</h2>
		    			<p>Bitte loggen sie sich mit ihrem Account ein.</p>
	    				$LoginForm
	    				<p>Noch kein Login? Dann k&ouml;nnen sie sich <a href="{$Link}?registration=1" title="Registration Health Analyser">hier</a> registrieren.</p>
	    			<% end_if %>
	    		<% end_if %>
		    </div>
	    	<div class="col-xs-12 col-sm-6">
	    		<h2>Ihre Health Daten</h2>
		    	<% if $CurrentMember %>
		    		<p>Ihre aktuell importierten Daten sehen sie in der darunter liegenden Tabelle. Wenn sie ein neues XML File &uuml;ber die Importfunktion importieren, werden im XML nicht mehr enthalten Daten ebenfalls aus der Datenbank von Health Daniek gel&ouml;scht.</p>
		    		<table>
		    			<tr>
		    				<th>Type</th>
		    				<th>Anzahl</th>
		    			</tr>
		    			<tr>
		    				<td>Gewicht</td>
		    				<td>$WeightCount</td>
		    			</tr>
		    			<tr>
		    				<td>Blutdruck</td>
		    				<td>$BloodPresureCount</td>
		    			</tr>
		    			<tr>
		    				<td>Puls</td>
		    				<td>$HearthRateCount</td>
		    			</tr>
		    		</table>
		    		<h2>Health Daten Import</h2>
		    		<p>Das Health XML k&ouml;nnen sie auf dem iPhone in der Health-App im Men&uuml; Daten unter "Alle" mit der Exportfunktion am rechten oberen Rand exportieren.</p>
			    	$ImportForm
		      	<% else %>
		      		Sie m&uuml;ssen eingeloggt sein um Daten importieren oder sehen zu k&ouml;nnen.
		        <% end_if %>
			</div>
    	</div>
	
	</div>
</section>