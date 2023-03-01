<!-- This file should primarily consist of HTML with a little bit of PHP. -->



<?php
/**
 * The template for displaying the mobile navigation icon.
 */

// Get the selected icon class from the options
$selected_icon = get_option('mobile_nav_icon');

// Only show the icon on mobile devices
if(wp_is_mobile() && !empty($selected_icon)) { ?>
  <div class="mobile-nav-icon">
    <i class="fa <?php echo esc_attr($selected_icon); ?>"></i>
  </div>
<?php } ?>
