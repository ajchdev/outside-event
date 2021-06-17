jQuery(document).ready(function($) {

	"use strict";
	var ajaxurl = outside_event_custom.ajax_url;
    var ajaxNonce = outside_event_custom.ajax_nonce;

    $('.event-filter-form').submit(function(){

    	// alert();
    	var month = $(this).find('.filter-event-month').val();
    	var type = $(this).find('.filter-event-type').val();
    	var tags = $(this).find('.filter-event-tags').val();

    	var data = {
	        'action': 'outside_event_event_filter',
	        '_wpnonce': ajaxNonce,
	        'month': month,
	        'type': type,
	        'tags': tags,
	    };

	    $.post(ajaxurl, data, function( response ) {

	    	$('.events-lists-wrap').empty();
	    	$('.events-lists-wrap').html( response );
	    	alert();
		        
	    });

	    return false;

    });
    
});