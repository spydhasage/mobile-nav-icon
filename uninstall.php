<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * @package Mobile_Nav_Icon
 */

// If uninstall not called from WordPress, then exit.
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete the plugin settings from the database.
delete_option('mobile_nav_icon_menu_items');
delete_option('mobile_nav_icon_font_awesome_version');

// Remove the mobile_nav_icon custom meta field from all posts and pages.
$posts = get_posts(array(
    'numberposts' => -1,
    'post_type' => array('post', 'page'),
    'meta_key' => 'mobile_nav_icon',
));

foreach ($posts as $post) {
    delete_post_meta($post->ID, 'mobile_nav_icon');
}
