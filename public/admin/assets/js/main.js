$.noConflict();

jQuery(document).ready(function($) {

	"use strict";

	[].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
		new SelectFx(el);
	} );

	jQuery('.selectpicker').selectpicker;


	$('#menuToggle').on('click', function(event) {
		$('body').toggleClass('open');
	});

	$('.search-trigger').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').addClass('open');
	});

	$('.search-close').on('click', function(event) {
		event.preventDefault();
		event.stopPropagation();
		$('.search-trigger').parent('.header-left').removeClass('open');
	});

	// $('.user-area> a').on('click', function(event) {
	// 	event.preventDefault();
	// 	event.stopPropagation();
	// 	$('.user-menu').parent().removeClass('open');
	// 	$('.user-menu').parent().toggleClass('open');
	// });


	//Image option selection
	$('.radiobtn').change(function(){

		let wrap = $(this).closest('.wrapper').find('.input_wrap');
		let thisval = $(this).val();
		let inpname = $(this).data('inp');

		wrap.empty();
		
		if ( thisval == 0 ) {
			wrap.append(`
							<input type="text" name="`+inpname+`" class="form-control" placeholder="Enter Option">
					`);
		}else{
			wrap.append(`
							<input type="file" name="`+inpname+`" class="form-control">
					`);
		}
		

	});

});