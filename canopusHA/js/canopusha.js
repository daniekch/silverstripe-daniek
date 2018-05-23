$( document ).ready(function() {
	$( "label.switch-light" ).bind( "click", function() {
		event.preventDefault();
		$.get($(location).attr('href') + "/lightswitch", function( data ) {
			
			if (data == 'ON') {
				$('#inptSwitch').prop('checked', true);
			}
			else if (data == 'OFF') {
				$('#inptSwitch').prop('checked', false);
			}
		});
	});
});

