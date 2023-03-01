<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://damilolasteven.com
 * @since      1.0.0
 *
 * @package    Mobile_Nav_Icon
 * @subpackage Mobile_Nav_Icon/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Mobile_Nav_Icon
 * @subpackage Mobile_Nav_Icon/includes
 * @author     Damilola Ajila <hajidamilola91@gmail.com>
 */
class Mobile_Nav_Icon_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'mobile-nav-icon',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
