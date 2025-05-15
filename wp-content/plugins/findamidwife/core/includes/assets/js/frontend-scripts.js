/*------------------------- 
Frontend related javascript
-------------------------*/

(function( $ ) {

	    
	jQuery(document).on('click touchstart', '#map_holder.minimized', function() {
		if (jQuery(window).width() < 768) {
			jQuery('#map_holder').addClass('fullscreen').removeClass('minimized');
			jQuery('#close_map').show();
			jQuery('#map_holder, #close_map').css('margin-left', '100%').animate({
				'marginLeft': 0
			}, 240, function(){
				loadMap(theLocation['lat'], theLocation['lng'], true);
				jQuery('#hd').hide();
			});
		}
	});
	
	jQuery(document).on('click touchstart', '#close_map', function() {
		jQuery('#hd').show();
		if (jQuery(window).width() < 768) {
			jQuery('#map_holder, #close_map').css('margin-left', 0).animate({
				'marginLeft': '100%'
			}, 240, function(){
				jQuery('#map_holder').removeClass('fullscreen').addClass('minimized').css('margin-left', 0);
				jQuery('#close_map').toggle();
				loadMap(theLocation['lat'], theLocation['lng'], true);
			});
			return false;
		}
	});
	
	jQuery(window).resize(function(){
		if (jQuery(window).width() > 768) {
			jQuery('#form').show();
			if (jQuery('#map_holder.fullscreen').length) {
				jQuery('#map_holder.fullscreen').removeClass('fullscreen').addClass('minimized');
				jQuery('#close_map').hide();
				loadMap(theLocation['lat'], theLocation['lng'], true);
			}
		}
	});
	
	jQuery(document).on('click touchstart', 'form input[type=submit]', function() {
		if (jQuery('input[name=postcode]').val() == '') {
			jQuery('input[name=postcode]').css('background-color','#ea5441');
			setTimeout( function(){
			  jQuery('input[name=postcode]').css('background-color','#ffffff');
			}, 1000);
			return false;
		}
	});

	jQuery(document).on('click', '#toggles span:not(.active)', function(){
		jQuery('#toggles span').toggleClass('active');
		jQuery('#results').toggleClass('list_view');
		jQuery('#results').toggleClass('image_view');
		doResize();
	});

})( jQuery );


