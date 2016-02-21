(function($){

	$(document).ready(function(){

		var location = {
			'lat' : null,
			'lng' : null
		};		

		// autocomplete address changed
        var autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('sid_nsna_autocomplete_pl3')),
        {
          types: ['geocode'],
          componentRestrictions: {country: 'in'}
        });
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
        	$('#sid_nsna_formattedAddress_pl3').text('Please wait ...')
            var place = autocomplete.getPlace();
            location.lat =  place.geometry.location.lat();
            location.lng =  place.geometry.location.lng();
            // document.getElementById("sid_nsna_formattedAddress_pl3").innerHTML = place.formatted_address
	       	initialize(location); // get address for the latlng
        });

        // on focus setting bound nearby
		$('#sid_nsna_autocomplete_pl3').on('focus', function(){
			$('.sid_nsna_status_pl3').empty(); // clear error status if any.
			if (navigator.geolocation) {
			    navigator.geolocation.getCurrentPosition(function(position) {
			      	var geolocation = {
				        lat: position.coords.latitude,
				        lng: position.coords.longitude
			      	};
			      	var circle = new google.maps.Circle({
				        center: geolocation,
				        radius: position.coords.accuracy
			      	});
			      autocomplete.setBounds(circle.getBounds());
			    });
			}
		});
		
		// initialize();
	})

///----------- Get Current Location -----------------------
	function initialize( ll ) 
	{
		if( typeof(ll) != 'undefined' )
		{
			var geocoder = new google.maps.Geocoder;
			var latlng = {lat: parseFloat(ll.lat), lng: parseFloat(ll.lng)};
			geocoder.geocode({'location': latlng}, function(results, status) {
			    if (status === google.maps.GeocoderStatus.OK) {
			      	if (results[1]) 
			      	{
			      		console.log( results ); // will display the JSON of all details
			      		document.getElementById("sid_nsna_formattedAddress_pl3").innerHTML = results[1].formatted_address
				    	document.getElementById("sid_nsna_latlng_pl3").value = latlng.lat+','+latlng.lng;
				    } 
				    else 
			        window.alert('No results found');
			    } 
			    else 
			      window.alert('Geocoder failed due to: ' + status);
			});
		}
		else
		{
			if(navigator.geolocation) 
			{
	        	navigator.geolocation.getCurrentPosition(function (position) 
	        	{

	    			var geocoder = new google.maps.Geocoder;
	    			var latlng = {lat: parseFloat(position.coords.latitude), lng: parseFloat(position.coords.longitude)};
					geocoder.geocode({'location': latlng}, function(results, status) {
					    if (status === google.maps.GeocoderStatus.OK) {
					      	if (results[1]) 
					      	{
					      		console.log( results ); // will display the JSON of all details
					      		document.getElementById("sid_nsna_formattedAddress_pl3").innerHTML = results[1].formatted_address
						    	document.getElementById("sid_nsna_latlng_pl3").value = latlng.lat+','+latlng.lng;
						    } 
						    else 
					        window.alert('No results found');
					      
					    } 
					    else 
					      window.alert( status + 'Sorry! Please reload the page.');
					});
				});
	   		} 
	   		else { 
	        	alert("Geolocation is not supported by this browser.")
	    	}
		}
	}

// subcategory fetching on click on a category
	$('.sid_catsSearch_pl3').click(function()
	{
		var cat = $(this).data('cat');
		$('.sid_nsna_subItems_pl3').empty();
		$('#sid_nsna_autocomplete_pl3').empty();
		$('.sid_nsna_formattedAddress_pl3').empty();
		$('.sid_nsna_selectedService_pl3').text('Choose Service');
		$("input[name='sid_nsna_chosenCat_pl3']").val(cat);
		$('.sid_nsna_modal_cat').text( cat );

		var data = {
            action: 'sid_nsna_ajax_pl3',
            token: 'get_particular_subcats',
            data_sent: {'cat': cat}
        };

        $.post(MyAjax.ajaxurl, data, function(resp) {
        	if( resp[0] == "null" )
        	{
        		$('.sid_nsna_subItems_pl3').append('<li><a href="#" class="service_pl3">'+cat+'</a></li>');
        	}
        	else
        	{
        		$.each(resp, function(index, val){
        			$('.sid_nsna_subItems_pl3').append('<li><a href="#" class="service_pl3">'+ val['cat'] +'</a></li>');
        		})
        		
        	}
        },'json').responseJSON;
	})

	// Select sub category
	$('body').on('click', ".service_pl3", function(e){
		e.preventDefault();
		$('.sid_nsna_status_pl3').empty(); // clear error status if any.
       	$(".sid_nsna_selectedService_pl3").text($(this).text());
       	$("input[name='sid_nsna_chosenCat_pl3']").val($(this).text());
    });

	// Find near me button
    $('.sid_nsna_locateMe_pl3').click(function(e){
    	e.preventDefault();
    	$('.sid_nsna_status_pl3').empty(); // clear error status if any.
    	$('#sid_nsna_formattedAddress_pl3').text('Please wait ...')
    	initialize();
    })

    // Search button pressed
    $('.sid_nsna_btnSearch_pl3').click(function(e){
    	e.preventDefault();
    	$('.sid_nsna_status_pl3').empty(); // clear error status if any.
    	var go = true;
    	var form = $(this).closest('form');
    	if( form.find('#sid_nsna_latlng_pl3').val().length < 5 ){
    		form.find('.sid_nsna_status_pl3').append('<div>Please choose correct address.</div>')
    		go = false;
    	}
    	if( form.find('input[name="sid_nsna_chosenCat_pl3"]').val().length < 2  ){
    		form.find('.sid_nsna_status_pl3').append('<div>Please choose a sub-service.</div>')
    		go = false;
    	}
    	if(go)
    		form.submit();
    })

})(jQuery);