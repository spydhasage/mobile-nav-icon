(function( $ ) {
	'use strict';

	jQuery(document).ready(function($) {
		// Define variables
		var iconSelect = $('.mobile-nav-icon-select');
		var iconPreview = $('.mobile-nav-icon-preview i');
	  
		// Show selected icon on page load
		iconPreview.addClass(iconSelect.val());
	  
		// Update selected icon on select change
		iconSelect.on('change', function() {
		  // Remove all previous icon classes
		  iconPreview.removeClass().addClass('fa');
	  
		  // Add the selected icon class
		  iconPreview.addClass($(this).val());
		});
	  
		// Reset icon to default
		$('.mobile-nav-icon-reset').on('click', function() {
		  // Remove all previous icon classes
		  iconPreview.removeClass().addClass('fa fa-bars');
	  
		  // Set select value to default
		  iconSelect.val('fa-bars');
		});
	  });
	  

})( jQuery );
