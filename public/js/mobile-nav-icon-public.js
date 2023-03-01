jQuery(document).ready(function($) {

	// Check if current device is mobile
	function isMobileDevice() {
	  return (typeof window.orientation !== "undefined") || (navigator.userAgent.indexOf('IEMobile') !== -1);
	};
  
	if (isMobileDevice()) {
	  
	  // Loop through each menu item
	  $('.menu-item').each(function() {
		
		// Get menu item ID
		var menuItemID = $(this).attr('id').replace('menu-item-', '');
		
		// Get stored icon class
		var storedIconClass = localStorage.getItem('mobile_nav_icon_' + menuItemID);
		
		// If icon class is stored, add icon to menu item
		if (storedIconClass) {
		  $(this).children('.menu-link').prepend('<i class="' + storedIconClass + '"></i>');
		}
		
	  });
	  
	}
  
  });
  