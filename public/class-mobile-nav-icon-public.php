<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://damilolasteven.com
 * @since      1.0.0
 *
 * @package    Mobile_Nav_Icon
 * @subpackage Mobile_Nav_Icon/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Mobile_Nav_Icon
 * @subpackage Mobile_Nav_Icon/public
 * @author     Damilola Ajila <hajidamilola91@gmail.com>
 */
class Mobile_Nav_Icon_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name       The name of the plugin.
	 * @param    string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/mobile-nav-icon-public.css', array(), $this->version, 'all' );

		// Enqueue Font Awesome stylesheet
		wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/mobile-nav-icon-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Generate the mobile menu HTML with icons.
	 *
	 * @since    1.0.0
	 */
	public function generate_mobile_menu() {
	  // Get the menu items
	  $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['mobile-menu']);

	  // If no menu items found, display error message
	  if (!$menu_items) {
	    echo '<p>No menu items found.</p>';
	    return;
	  }

	  // Generate the mobile menu
	  echo '<ul>';
	  foreach ($menu_items as $item) {
	    // Get the icon class from the menu item meta
	    $icon = get_post_meta($item->ID, '_mobile_menu_icon', true);

	    // Display the menu item with or without the icon
	    echo '<li>';
	    echo '<a href="' . $item->url . '">' . $item->title;
	    if ($icon) {
	      echo '<i class="fa ' . $icon . '"></i>';
	    }
	    echo '</a>';
	    echo '</li>';
	  }
	  echo '</ul>';
	}
}