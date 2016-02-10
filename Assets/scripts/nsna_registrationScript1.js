(function($){

    // [  GET Subcategories based on checked categories  ] 
    //          [  Add Tag-Subcategories  ]
    var service ={}
    $('.nsna-cats-pl3').on('change', function(){
        var cat_checked = {};
       if(this.checked)
        {
            cat_checked[$(this).data('count')] = $(this).val();
            // console.log(cat_checked)
            var data = {
                action: 'sid_nsna_ajax_pl3',
                token: 'get_subcats',
                data_sent: cat_checked,
            };
            $.post(MyAjax.ajaxurl, data, function(response) {
                console.log(response)

                    $.each(response, function( index, value ) {
                        var clone1 = $('.services_pl3').find('.nsna_cats_pl3').first().clone()
                        clone1.removeClass('nsna_hide_this_pl3');
                        // clone1.addClass('required_pl3');
                        clone1.find('.nsna_cat_pl3').text(index)
                        if( $.isArray( value ) )
                        {
                            $.each(value, function(i,k){
                                   var clone2 = $('.services_pl3').find('.nsna_subcat_pl3').first().clone().removeClass('nsna_hide_this_pl3').text(k['cat']);
                                   clone2.attr('data-index', i);
                                   clone1.find('.nsna_subcats_pl3').append(clone2);
                            })
                        }
                        else
                        {
                            var clone2 = $('.services_pl3').find('.nsna_subcat_pl3').first().clone().text('No services');
                            clone2.attr('data-index', '9');
                            clone1.find('.nsna_subcats_pl3').append(clone2);
                        }
                        $('.services_pl3').append(clone1);
                    })

            },'json').responseJSON;
        }
        else
        {
            var self = $(this);
            delete cat_checked[self.data('count')];
            $('.services_pl3').find('.nsna_cat_pl3').each(function(){
                if($(this).text() == self.val()){
                    $(this).closest('.nsna_cats_pl3').remove();
                }
            })
        }
    })
    
    //          [  DELETE Tag-Subcategories  ]
    $('.services_pl3').on('click', '.nsna_subcat_pl3', function(){
        if( confirm( "Delete service : "+$(this).text() ) ){
            if($(this).closest('.nsna_subcats_pl3').find('.nsna_subcat_pl3').length < 3){
                alert('Must have atleast one service');
            }
            else
                $(this).remove();
        }
    })

     // --- Create account --- //
    $('.sid-nsna-createAccountShop-pl3').click(function(e){
        e.preventDefault()
        var form = $('#nsns_RegForm_pl3');
        var errors = {
            'count' : 0,
            'msg' : []
        }
        var data_to_send = {};
        form.find('.jq_IP_pl3').each(function(){

            if($(this).hasClass('text-pl3')){
                if( $(this).text().length > 2 )
                    data_to_send[$(this).attr('id')] = $(this).text();
                else
                {
                    errors.count++;
                    errors.msg.push( 'Error! '+$(this).data('msg')+' value is missing' )
                }
            }
            else
            {   
                if( $(this).val().length > 2 )
                    data_to_send[$(this).attr('id')] = $(this).val();
                else
                {
                    if ( $(this).attr('id') != 'landmark' ) 
                    {
                        errors.count++;
                        errors.msg.push( 'Error! '+$(this).attr('id')+' is missings' )
                    }
                }
            }
        })
        data_to_send['services'] = {};
        var srvcs = form.find('.services_pl3').find('.nsna_cats_pl3');
        if(srvcs.length != 1)
            srvcs.each(function(){
                if(! $(this).hasClass('nsna_hide_this_pl3'))
                {
                    var catt = $(this).find('.nsna_cat_pl3').text();
                    data_to_send['services'][catt] = [];
                    
                    $(this).find('.nsna_subcat_pl3').each(function(){
                        if( ! $(this).hasClass('nsna_hide_this_pl3') )
                            data_to_send['services'][catt].push( $(this).text() )
                    })
                }
            })
        else
        {
            errors.count++;
            errors.msg.push( 'Error! Service values are missing' ) 
        }


        if( errors.count == 0 )
            console.log( data_to_send );
        else
        {
            $.each( errors.msg, function( i, v){
                form.find('.nsna_mike').append('<div>'+v+'</div>')
            } );
        }

        var data = {
            action: 'sid_nsna_ajax_pl3',
            token: 'register_shop',
            data_sent: data_to_send,
        };

        $.post(MyAjax.ajaxurl, data, function(response) {
            if(response.status == 200)
            {
                $('form#nsns_RegForm_pl3').empty()
                $('form#nsns_RegForm_pl3').html('<div style="background-color:#00CC66; padding:10px 15px; border-radius: 5px; color:white;">Success! Registration Was Completed! </div>')
                $('.sid-nsna-createAccountShop-pl3').remove()          
            }
            else if( response.status == 504 ){
                $.each( response.message, function(i, v){
                    form.find('.nsna_mike').append('<div>'+v+'</div>')
                });
            }
            else
                $('div#sid_nsna_mike_pl3').html('<div style=" background-color:#CC0033; padding:10px 15px; border-radius: 5px; color:white;">Failed! Registration Failed! Sorry for the inconvenience. </div>')
        },'json').responseJSON;
    })

    $('.jq_IP_pl3').on('focus', function(){
        $('.nsna_mike').empty();
    })

// [ START init autocomplete feature ]
        var placeSearch, autocomplete;
        var componentForm = {
          street_number: 'short_name',
          route: 'long_name',
          locality: 'long_name',
          administrative_area_level_1: 'short_name',
          country: 'long_name',
          postal_code: 'short_name'
        };

        $(document).ready(function() {

            // Create the autocomplete object, restricting the search
            // to geographical location types.
            autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById('nsna-autocompleteAddress-pl3')),
            {
                types: ['geocode'],
                componentRestrictions: {country: 'in'}
            });

            // When the user selects an address from the dropdown,
            // populate the address fields in the form.
            google.maps.event.addListener(autocomplete, 'place_changed', function() {
                sid_nsna_loadAddress_pl3();
            });
        })

// [START region_fillform THE MAP ]
        function sid_nsna_loadAddress_pl3() {
            // console.log(autocomplete.getPlace());
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();

            sid_nsna_fillAddress_pl3(place.address_components);
            $('#lat_pl3').text(autocomplete.getPlace().geometry.location.lat())
            $('#lng_pl3').text(autocomplete.getPlace().geometry.location.lng())
            $('.formatted_address_pl3').text(autocomplete.getPlace().formatted_address)

            var mapOptions = {
                center: autocomplete.getPlace().geometry.location,
                zoom: 14
            };

            $('#lat_lng_map_pl3').show();
            $('.formattedAddress_pl3').show();
            map = new google.maps.Map(document.getElementById('lat_lng_map_pl3'), mapOptions);
            marker = new google.maps.Marker({
                map: map,
                position: autocomplete.getPlace().geometry.location
            });

            google.maps.event.addListener(map, 'click', function(event) {
                var latitude = event.latLng.lat();
                var longitude = event.latLng.lng();
                var latlongString  = latitude + ',' + longitude;
                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': event.latLng}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                            // console.log(results);
                            $('.formatted_address_pl3').text(results[0].formatted_address);
                            sid_nsna_fillAddress_pl3(results[0].address_components);
                    }
                });

                marker.setPosition( event.latLng ); map.panTo( event.latLng );
                $('#lat_pl3').text(latitude); $('#lng_pl3').text(longitude);
                // alert(latitude)
                
            });

            $('#lat_lng_map_pl3').show();
        }
// [ END ]

// // [ START Textbox filling] -->]
        function sid_nsna_fillAddress_pl3 (address_components) {

            $('#zip_pl3').text('');

            for (var i = 0; i < address_components.length; i++) {
                var addressComponent = address_components[i];
                if (addressComponent.types[0] == 'postal_code'){
                    $('#zip_pl3').text(addressComponent['short_name']);
                }
            }
        }
// END MAP    // [ ENDS ]   

$('.nsna_contactUS_pl3').click(function(e){
    e.preventDefault();
    var form = $('.nsna_contactUS_form');
    var data_to_send = {};
    var err ={
        count : 0,
        msg: []
    }
    form.find('.cu_jsIP_pl3').each(function(){
        if( $(this).val().length > 2 ){
            data_to_send[$(this).attr('id')] = $(this).val()
        }
        else
        {
            // console.log($(this).val())
            if( $(this).parent().hasClass('username-cs') )
                data_to_send[$(this).attr('id')] = $(this).val()
            else{
                err.count ++;
                err.msg.push('Error: '+ $(this).attr('id') + ' seems empty.');
            }
        }
    })
    if(err.count == 0)
    {
        console.log(data_to_send)
        var data = {
            action: 'sid_nsna_ajax_pl3',
            token: 'contact_shop',
            data_sent: data_to_send,
        };

        $.post(MyAjax.ajaxurl, data, function(response) {
            console.log(response);
            if(response == 200)
            {
                form.find('.nsna_ContactUsmike_pl3').html('<div style="background-color:#00CC66; padding:10px 15px; margin-bottom:15px; border-radius: 5px; color:white;">Success! Your request was sent! </div>')
                // $('form#nsns_RegForm_pl3').html('<div style="background-color:#00CC66; padding:10px 15px; margin-bottom:15px; border-radius: 5px; color:white;">Success! Registration Was Completed! </div>')
                // $('.sid-nsna-createAccountShop-pl3').remove()          
            }
            else {
                form.find('.nsna_ContactUsmike_pl3').html('<div style="background-color:red; padding:10px 15px; margin-bottom:15px; border-radius: 5px; color:white;">Failed! Your request was not sent! </div>')
            }
        },'json').responseJSON;
    }
    else
    {
        $.each(err.msg,function(i,v){
            form.find('.nsna_ContactUsmike_pl3').append('<div style="color:#e00;">'+v+'</div>')
        })
    }
})     

    
})(jQuery);
