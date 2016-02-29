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
			$('.nsna_shpName').val( $(this).closest('form').find('input[name="name"]').val() )
		})

		// On Confirm Appointment clicked
		$('.nsna_checkHuman').click(function(e){
			e.preventDefault();
			var form = $(this).closest('form');
			var self = $(this)
			form.find('.nsna_status').empty()
			var flg = [];
			form.find('.jq_checkAppo_frm').each(function(){
				if( $(this).val().length < 3 )
					flg.push($(this).data('msg'));
			})
			
			if(flg.length < 1){
				form.find('.nsna_status').empty()
				if( confirm("Sure about the appointment time? "+$('#nsna_timestamp_pl3').val()) ){
					self.attr('disabled', true);
					var data_e = {};
					form.find('.jq_checkAppo_frm').each(function(){
						data_e[$(this).data('name')] = $(this).val();
					})
					// console.log(data_e);
					var data = {
			            action: 'sid_nsna_ajax_pl3',
			            token: 'generate_OTP_for_him',
			            data_sent: data_e
			        };

			        $.post(MyAjax.ajaxurl, data, function(resp) {
			        	console.log(resp)
			        	if( resp.status == 200 ){
			        		$('.nsna_otp_cont').slideDown();
							$(this).slideUp();
							form.find('.nsna_status').append('<div style="color:#5b5;">'+resp.msg+'</div>')
			        	}
			        	else
			        	{
			        		$.each( resp.msg, function( i, v) {
			        			form.find('.nsna_status').append('<div>'+v+'</div>')
			        		})
			        		self.attr('disabled', false);

			        	}
			        },'json').responseJSON;
				}
			}
			else
				$.each(flg,function(k,v){
					form.find('.nsna_status').append('<div>'+v+'</div>')
				})
		})

		// On Bootstrap modal closed
		$('#sid_nsna_appoModal_pl3').on('hidden.bs.modal', function () {
		    $(this).find('.nsna_otp').val("");
		    $(this).find('.nsna_otp_cont').hide();
		    $(this).find('.nsna_checkHuman').show();
		    $(this).find('.nsna_status').empty()
		})

		$('.nsna_very_otp').click(function(e){
			e.preventDefault();
			var form = $(this).closest('form');
			var self = $(this)
			var data_to_send = {};
			form.find('.nsna_JQ_setAppo').each(function(){
				data_to_send[ $(this).data('name') ] = $(this).val();
			})

			console.log(data_to_send);

			var data = {
	            action: 'sid_nsna_ajax_pl3',
	            token: 'verify_OTP',
	            data_sent: data_to_send
	        };

	        $.post(MyAjax.ajaxurl, data, function(resp) {
	        	console.log(resp)
	        	if( resp.status == 200 ){
	        		$('.nsna_otp_cont').slideDown();
					$(this).slideUp();
					form.find('.nsna_status').append('<div style="color:#5b5;">'+resp.msg[0]+'</div>')
	        	}
	        	else
	        	{
	        		$.each( resp.msg, function( i, v) {
	        			form.find('.nsna_status').append('<div>'+v+'</div>')
	        		})
	        		self.attr('disabled', false);

	        	}
	        },'json').responseJSON;

		})


})(jQuery);
