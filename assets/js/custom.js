jQuery(document).ready(function($) {

	"use strict";
	var ajaxurl = outside_event_custom.ajax_url;
    var ajaxNonce = outside_event_custom.ajax_nonce;

    $('.event-filter-form').submit(function(){

    	// alert();
    	var month = $(this).find('.filter-event-month').val();
    	var type = $(this).find('.filter-event-type').val();
    	var tags = $(this).find('.filter-event-tags').val();
        var limit = $(this).find('.filter-event-limit').val();

        var c_element = $(this);
    	var data = {
	        'action': 'outside_event_event_filter',
	        '_wpnonce': ajaxNonce,
	        'month': month,
	        'type': type,
	        'tags': tags,
            'limit': limit,
	    };

	    $.post(ajaxurl, data, function( response ) {

	    	$(c_element).closest('.outside-events-lists').find('.events-lists-wrap').empty();
	    	$(c_element).closest('.outside-events-lists').find('.events-lists-wrap').html( response );
	    	alert();
		        
	    });

	    return false;

    });
    
    $(".outside-event-slider").each(function () {

        $(this).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: true,
            autoplay: false,
            autoplaySpeed: 8000,
            infinite: true,
            dots: false,
        });

    });

    $('.otuside-pagination').click(function(){

        var month = $(this).closest('.outside-events-lists').find('.filter-event-month').val();
        var type = $(this).closest('.outside-events-lists').find('.filter-event-type').val();
        var tags = $(this).closest('.outside-events-lists').find('.filter-event-tags').val();

        // alert();
        var month = $(this).closest('.outside-events-lists').find('.filter-event-month').val();
        var type = $(this).closest('.outside-events-lists').find('.filter-event-type').val();
        var tags = $(this).closest('.outside-events-lists').find('.filter-event-tags').val();
        var c_element = $(this);
        var paged = $(this).closest('.outside-events-lists').find('.otuside-pagination').attr('paged-data');
        var limit = $(this).closest('.outside-events-lists').find('.otuside-pagination').attr('data-limit');

        var data = {
            'action': 'outside_event_event_pagination',
            '_wpnonce': ajaxNonce,
            'month': month,
            'type': type,
            'tags': tags,
            'paged': paged,
            'limit': limit,
        };

        $.post(ajaxurl, data, function( response ) {

            if( response ){
                paged++;
                $(c_element).closest('.outside-events-lists').find('.otuside-pagination').attr('paged-data',paged);

                // $(c_element).closest('.outside-events-lists').find('.events-lists-wrap').empty();
                $(c_element).closest('.outside-events-lists').find('.events-lists-wrap').append( response );
            }else{
                $(c_element).closest('.outside-events-lists').find('.otuside-pagination').html( outside_event_custom.no_posts );
            }
                
        });

    });

});