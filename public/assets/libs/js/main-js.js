$(document).ready(function() {

    'use strict';

    // ==============================================================
    // generate random star
    // ==============================================================
    $('.top20-random-generator').click(function () {
    	var target = $(this).parent().siblings('.target');
    	var value = target.val();
    	var root = $('meta[name=root]').attr('content');
    	var path = root+'/random/20?filters='+value;
    	$.get(path, function(data, status){
    	    var result = value ? value+','+data : data;
    	    target.val(result);
    	});
    });

    $('.generate-random-star').click(function () {
    	var root = $('meta[name=root]').attr('content');
    	var path = root+'/random';
    	var tops = $(this).attr('data-tops');
    	if (tops) path += '/'+tops;
    	$.get(path, function(data, status){
    		$('.random-star-box #stars-list').append('<p>'+data+'</p>');
    	});
    });

    // ==============================================================
    // semi-final-title trigger
    // ==============================================================
    $('.semi-final-title > small').click(function () {
    	$(this).parent().siblings('.show-details').toggle();
    	$(this).parent().siblings('.change-details').toggle();
    });

    // ==============================================================
    // change room trigger
    // ==============================================================
    $('.trigger-change-room').click(function () {
    	var row = $(this).attr('data-row-number');
    	$('.change-room-'+row).slideToggle();
    });


    // ==============================================================
    // keyboards
    // ==============================================================
    window.addEventListener("keydown",function (e) {

    	// f1
    	if (e.keyCode === 112) {
    		e.preventDefault();
    		$('#string').focus();
    	}
    	// f2
    	if (e.keyCode === 113) {
    		e.preventDefault();
    		$('#star-add').focus();
    	}
    	// f3
    	if (e.keyCode === 114) {
    		e.preventDefault();
    		$('#header-search').focus();
    	}

    });

    // ==============================================================
    // initializers
    // ==============================================================
	if ($('[data-toggle="tooltip"]').length) {
		$('[data-toggle="tooltip"]').tooltip();
	}
	if ($('[data-toggle="popover"]').length) {
		$('[data-toggle="popover"]').popover();
	}

}); // AND OF JQUERY
