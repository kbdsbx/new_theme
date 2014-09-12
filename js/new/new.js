/*
 * Copyright (c) 24/04/2013 kbdsbx
 * Author: kbdsbx
 * This file is made for NEWS
*/

	

// ----------------------------------------------------  CONTACT FORM
jQuery(function(){
	// -----------------------------------------------------  FLEXSLIDER
	jQuery('.flexslider').flexslider({
		animation: 'fade',
		controlNav: false,
		slideshowSpeed: 4000,
		animationDuration: 300
	});	
})

jQuery(function() {

	jQuery('#carousel').carouFredSel({
		width: '100%',
		direction   : "bottom",
		scroll : 400,
		items: {
			visible: '+3'
		},
		auto: {
			items: 1,
			timeoutDuration : 4000
		},
		prev: {
			button: '#prev1',
			items: 1
		},    
		next: {
			button: '#next1',
			items: 1
		}
	});
	
	jQuery('#carousel2').carouFredSel({
		width: '100%',
		direction   : "left",
		scroll : {
	        duration : 800
	    },
		items: {
			visible: 1
		},
		auto: {
			items: 1,
			timeoutDuration : 4000
		},
		prev: {
			button: '#prev2',
			items: 1
		},    
		next: {
			button: '#next2',
			items: 1
		}
	});

	

});

jQuery(document).ready(function(){
		
	"use strict";

// -----------------------------------------------------  UI ELEMENTS
	jQuery( "#accordion" ).accordion({
		heightStyle: "content"
	});
	
	jQuery( "#new-tabs" ).tabs();
	
	jQuery( "#tooltip" ).tooltip({
		position:{
			my: "center bottom-5",
			at: "center top"	
		}
	});
	
	
// -----------------------------------------------------  UI ELEMENTS	
	jQuery('#nav ul.sf-menu').mobileMenu({
		defaultText: 'Go to ...',
		className: 'device-menu',
		subMenuDash: '&ndash;'
	});
	
	
// -----------------------------------------------------  NOTIFICATIONS CLOSER
	jQuery('span.closer').click(function(e){
		e.preventDefault();
		jQuery(this).parent('.notifications').stop().slideToggle(500);
	});

// -----------------------------------------------------  NAV SUB MENU(SUPERFISH)
	jQuery('#nav ul.sf-menu').superfish({
		delay: 250,
		animation: {opacity:'show', height:'show'},
		speed: 300,
		autoArrows: true,
		dropShadows: false
	});
// -----------------------------------------------------  
    jQuery( "ul.social li" ).mouseenter( function() {
        var $this = jQuery(this);
        $this.find( '.follow' ).stop( true, false ).animate( { 'top': '-98px' }, 400 );
        $this.find( '.hover' ).stop( true, false ).css( { 'display': 'block' } ).animate( { 'top': '-98px' }, 400 );
    } );
    jQuery( "ul.social li" ).mouseleave( function() {
        var $this = jQuery(this);
        $this.find( '.follow' ).stop( true, false ).css( { 'display': 'block' } ).animate( { 'top': '0px' }, 400 );
        $this.find( '.hover' ).stop( true, false).animate( { 'top': '0px' }, 400 );
    } );
});
