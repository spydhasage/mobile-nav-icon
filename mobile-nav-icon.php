<?php

/**
 *
 * @link              https://damilolasteven.com
 * @since             1.0.0
 * @package           Mobile_Nav_Icon
 *
 * @wordpress-plugin
 * Plugin Name:       Mobile Nav Icon
 * Plugin URI:        https://damilolasteven.com
 * Description:       Adds Font Awesome icons to specific menu items when viewed on a mobile device
 * Version:           1.0.0
 * Author:            Damilola Ajila
 * Author URI:        https://damilolasteven.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mobile-nav-icon
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'MOBILE_NAV_ICON_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mobile-nav-icon-activator.php
 */
function activate_mobile_nav_icon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mobile-nav-icon-activator.php';
	Mobile_Nav_Icon_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mobile-nav-icon-deactivator.php
 */
function deactivate_mobile_nav_icon() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mobile-nav-icon-deactivator.php';
	Mobile_Nav_Icon_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mobile_nav_icon' );
register_deactivation_hook( __FILE__, 'deactivate_mobile_nav_icon' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mobile-nav-icon.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mobile_nav_icon() {

	$plugin = new Mobile_Nav_Icon();
	$plugin->run();

}

// Enqueue plugin styles
function enqueue_styles() {
	// Enqueue Font Awesome stylesheet
	wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css', array(), '5.15.3' );
	
	// Enqueue plugin stylesheet
	wp_enqueue_style( 'mobile-menu-icons', plugin_dir_url( __FILE__ ) . 'css/mobile-menu-icons.css', array(), '1.0.0' );
  }

  // Enqueue plugin scripts and styles
function enqueue_scripts() {
	// Enqueue jQuery and Select2 scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js', array( 'jquery' ), '4.1.0' );
	
	// Enqueue plugin script
	wp_enqueue_script( 'mobile-menu-icons', plugin_dir_url( __FILE__ ) . 'js/mobile-menu-icons.js', array( 'jquery', 'select2' ), '1.0.0' );
	
	// Enqueue Select2 stylesheet
	wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css', array(), '4.1.0' );
	
	// Enqueue plugin stylesheet
	wp_enqueue_style( 'mobile-menu-icons', plugin_dir_url( __FILE__ ) . 'css/mobile-menu-icons.css', array(), '1.0.0' );
  }

  function add_mobile_menu_icon_styles() {
	wp_enqueue_style('fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
  }
  add_action('wp_enqueue_scripts', 'add_mobile_menu_icon_styles');
  
  
  

//Menu Icon Function Begins here
function add_menu_icons( $items ) {
	// Get the current menu
	$locations = get_nav_menu_locations();
	$menu_id = $locations['primary'];
	
	if ( $menu_id ) {
	  $menu_items = wp_get_nav_menu_items( $menu_id );
  
	  // Loop through each menu item and add the icon
	  foreach ( $menu_items as $item ) {
		$icon = get_option( 'menu_item_icon_' . $item->ID );
		if ( $icon ) {
		  $items = str_replace( '<a', '<a><i class="' . esc_attr( $icon ) . '"></i> ', $items );
		}
	  }
	}
	return $items;
  }
add_filter( 'wp_nav_menu_items', 'add_menu_icons' );


// Add custom fields for menu items
function menu_item_icon_fields($item_id, $item, $depth, $args) {
	// Add a new field for the Font Awesome icon
	$icon = get_post_meta($item_id, '_menu_item_icon', true);
  ?>
	<div class="field-icon description-wide">
	  <label for="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>">
		<?php esc_html_e('Font Awesome Icon', 'mobile-menu-icons'); ?><br>
		<input type="text" class="widefat code edit-menu-item-icon" name="menu-item-icon[<?php echo esc_attr($item_id); ?>]" id="edit-menu-item-icon-<?php echo esc_attr($item_id); ?>" value="<?php echo esc_attr($icon); ?>">
	  </label> <!-- add this closing tag -->
	</div>
  <?php
  }
  

add_action( 'wp_nav_menu_item_custom_fields', 'menu_item_icon_fields', 10, 4 );

// Save custom fields for menu items
function save_menu_item_icon_fields($menu_id, $menu_item_db_id, $menu_item_args) {
  if ( isset( $_REQUEST['menu-item-icon'][$menu_item_db_id] ) ) {
    $icon = sanitize_text_field( $_REQUEST['menu-item-icon'][$menu_item_db_id] );
    update_post_meta( $menu_item_db_id, '_menu_item_icon', $icon );
  }
}

//a function that adds a new submenu page under the Appearance menu called "Mobile Menu Icons Settings".
function mobile_menu_icons_options_page() {
  add_submenu_page(
    'themes.php',
    'Mobile Menu Icons Settings',
    'Mobile Menu Icons',
    'manage_options',
    'mobile-menu-icons',
    'mobile_menu_icons_options_page_html'
  );
}

function mobile_menu_icons_options_page_html() {
  // Check user capabilities
  if ( ! current_user_can( 'manage_options' ) ) {
    return;
  }

  // Save settings
  if ( isset( $_POST['submit'] ) ) {
    $icons = $_POST['menu_item_icons'];
    foreach ( $icons as $id => $icon ) {
      update_option( 'menu_item_icon_' . $id, sanitize_text_field( $icon ) );
    }
    echo '<div class="updated"><p>Settings saved.</p></div>';
  }
  ?>
  <div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form method="post">
      <?php
      $menu_items = wp_get_nav_menu_items( 'primary' );
      if ( ! empty( $menu_items ) ) :
      ?>
        <table class="form-table">
          <tbody>
            <?php foreach ( $menu_items as $item ) : ?>
              <tr>
                <th scope="row"><label for="menu_item_icon_<?php echo esc_attr( $item->ID ); ?>"><?php echo esc_html( $item->title ); ?></label></th>
                <td><input type="text" name="menu_item_icons[<?php echo esc_attr( $item->ID ); ?>]" id="menu_item_icon_<?php echo esc_attr( $item->ID ); ?>" value="<?php echo esc_attr( get_option( 'menu_item_icon_' . $item->ID ) ); ?>"></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php submit_button(); ?>
      <?php else: ?>
        <p>No menu items found.</p>
      <?php endif; ?>
    </form>
  </div>
  <?php
}

// Display menu item icon settings
function menu_item_icon_settings( $item_id, $item ) {
	// Get saved icon class
	$icon_class = get_post_meta( $item_id, '_menu_item_icon', true );
	
	// Get all Font Awesome icons
	$icons = get_font_awesome_icons();
	
	// Create select element
	echo '<p class="field-icon description description-wide">';
	echo '<label for="edit-menu-item-icon-' . $item_id . '">';
	echo __( 'Icon', 'mobile-menu-icons' ) . '<br />';
	echo '<select class="widefat select2" id="edit-menu-item-icon-' . $item_id . '" name="menu-item-icon[' . $item_id . ']">';
	
	// Add default option
	echo '<option value="">' . __( 'None', 'mobile-menu-icons' ) . '</option>';
	
	// Add Font Awesome icons
	foreach ( $icons as $icon ) {
	  $selected = $icon_class == $icon['class'] ? 'selected' : '';
	  echo '<option value="' . $icon['class'] . '" ' . $selected . '>' . $icon['label'] . '</option>';
	}
	
	echo '</select>';
	echo '</label>';
	echo '</p>';
  }
  
  
  // Save menu icon settings when a menu item is updated
  function save_menu_item_icon_settings( $menu_id, $menu_item_db_id ) {
	if ( isset( $_POST['menu_item_icon_' . $menu_item_db_id] ) ) {
	  update_option( 'menu_item_icon_' . $menu_item_db_id, sanitize_text_field( $_POST['menu_item_icon_' . $menu_item_db_id] ) );
	} else {
	  delete_option( 'menu_item_icon_' . $menu_item_db_id );
	}
  }
  add_action( 'wp_update_nav_menu_item', 'save_menu_item_icon_settings', 10, 2 );
  
  
  
// Get all Font Awesome icons
function get_fontawesome_icons() {
	$icons = array(
	  'fa fa-500px',
	  'fa fa-address-book',
	  'fa fa-address-card',
	  // ...
	);
	return apply_filters( 'mobile_menu_icons_fontawesome_icons', $icons );
  }
  
  function generate_mobile_menu() {
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
  

add_action( 'admin_menu', 'mobile_menu_icons_options_page' );


add_action( 'wp_update_nav_menu_item', 'save_menu_item_icon_fields', 10, 3 );


run_mobile_nav_icon();
