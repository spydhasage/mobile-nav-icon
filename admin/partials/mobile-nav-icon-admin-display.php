<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://damilolasteven.com
 * @since      1.0.0
 *
 * @package    Mobile_Nav_Icon
 * @subpackage Mobile_Nav_Icon/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="wrap">
    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
    
    <?php if (isset($_GET['settings-updated']) && $_GET['settings-updated']) : ?>
        <div id="message" class="updated notice is-dismissible">
            <p><?php esc_html_e('Settings saved.'); ?></p>
            <button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e('Dismiss this notice.'); ?></span></button>
        </div>
    <?php endif; ?>

    <form method="post" action="options.php">
        <?php
            settings_fields('mobile_nav_icon_settings');
            do_settings_sections('mobile_nav_icon_settings');
        ?>
        <table class="form-table">
            <tbody>
                <?php foreach ($menu_items as $menu_item) : ?>
                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr($menu_item->ID); ?>"><?php echo esc_html($menu_item->title); ?></label></th>
                        <td>
                            <select id="<?php echo esc_attr($menu_item->ID); ?>" name="mobile_nav_icon[<?php echo esc_attr($menu_item->ID); ?>]">
                                <option value=""><?php esc_html_e('Select an icon'); ?></option>
                                <?php foreach ($font_awesome_icons as $icon) : ?>
                                    <option value="<?php echo esc_attr($icon); ?>" <?php selected(get_option('mobile_nav_icon_' . $menu_item->ID), $icon); ?>>
                                        <?php echo esc_html($icon); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php submit_button(__('Save Settings', 'mobile-nav-icon'), 'primary', 'submit', true); ?>
    </form>
</div>

