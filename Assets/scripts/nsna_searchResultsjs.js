(function($){

// alert( $('.nsna_lat').val() )
		$(document).ready(function(){

			var geocoder = new google.maps.Geocoder;
			var latlng = {lat: parseFloat($('.nsna_lat').val()), lng: parseFloat($('.nsna_lng').val())};
			geocoder.geocode({'location': latlng}, function(results, status) {
			    if (status === google.maps.GeocoderStatus.OK) {
			      	if (results[1]) 
			      	{
			      		console.log( results ); // will display the JSON of all details
			      		$('.nsna_formatted_address_pl3').val( results[1].formatted_address )
				    } 
				    else 
			        window.alert('Sorry! We failed to locate your search location');
			    } 
			    else 
			      window.alert('Error: '+status+ ' [ Please reload this page again. ]');
			});
		})

		// Date and time picker
		$('.nsna_dateTimePick_pl3').appendDtpicker({
			"inline": false,
			"dateFormat": "DD.MM.YY H:mmTT"
		});

		// Quick Book button pressed
		$('.nsna_quickBook').click(function(){
			// console.log( $(this).closest('form').find('input[name="name"]').val());
			$('.nsna_sch_for_name').text( $(this).closest('form').find('input[name="name"]').val() );
			$('.nsna_sch_for_tag').text( $(this).closest('form').find('input[name="type"]').val()+" | "+ $(this).closest('form').find('input[name="subtype"]').val() );
			
			$('.nsna_id').val( $(this).closest('form').find('input[name="_id"]').val() )
			$('.nsna_email').val( $(this).closest('form').find('input[name="email"]').val() )
			$('.nsna_type').val( $(this).closest('form').find('input[name="type"]').val() )
			$('.nsna_subtype').val( $(this).closest('form').find('input[name="subtype"]').val() )
		})

		// On Confirm Appointment clicked
		$('.nsna_checkHuman').click(function(e){
			e.preventDefault();
			$('.nsna_otp_cont').slideDown();
			$(this).slideUp();
		})

		// On Bootstrap modal closed
		$('#sid_nsna_appoModal_pl3').on('hidden.bs.modal', function () {
		    $(this).find('.nsna_otp').val("");
		    $(this).find('.nsna_otp_cont').hide();
		    $(this).find('.nsna_checkHuman').show();

		    // reset OTP counter
		})


})(jQuery);
