<?php

/*
  Plugin Name: B-Reputation Reviews
  Description: To Collect and display your clients' reviews and testimonials and transform them into Google stars.
  Version: 1.0.8
  Author: carolinebda
  Author URI: https://b-reputation.com
  License: GPLv2 or later
  License URI: http://www.gnu.org/licenses/gpl-2.0.html
  Text Domain: b-reputation-reviews
 */

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

require_once plugin_dir_path(__FILE__) . 'classes/singleton.class.php';
require_once plugin_dir_path(__FILE__) . 'classes/adminsettings.class.php';
require_once plugin_dir_path(__FILE__) . 'classes/frontdisplay.php';

define('B_Reputation_Settings', 'b_reputation_settings');
define('B_Reputation_Siren_Field', 'b_reputation_review_siren');
define('B_Reputation_Company_Name_Field', 'b_reputation_review_company_name');

if (is_admin()) {
    /**
     * register our b_reputation_settings_init to the admin_init action hook
     */ add_action('admin_init', array(\b_reputation\adminsettings ::get_instance(), 'b_reputation_settings_init'));

    /**
     * Register sub menu page for settings to a admin_menu action hook
     */ add_action('admin_menu', array(\b_reputation\adminsettings ::get_instance(), 'b_reputation_settings'));

    /**
     * Register stylesheet for admin
     */ add_action('admin_enqueue_scripts', array(\b_reputation\adminsettings::get_instance(), 'b_reputation_register_style'));

    /**
     * Add settings link
     */add_filter('plugin_action_links_' . plugin_basename(__FILE__), array(\b_reputation\adminsettings::get_instance(), 'add_action_links'));
}
/*
 * Shortcode to display reviews div at frontend.
 */
add_shortcode('b_reputation_display', array(\b_reputation\frontdisplay ::get_instance(), 'b_reputation_display'));
add_filter('script_loader_tag', array(\b_reputation\frontdisplay::get_instance(), 'add_attributes_to_script'), 10, 2);
add_action('wp_enqueue_scripts', array(\b_reputation\frontdisplay::get_instance(), 'b_reputation_register_script'));


/*
 * Code to load the translations
 */

function myplugin_init() {
    $plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages'; /* Relative to WP_PLUGIN_DIR */
    load_plugin_textdomain( 'b-reputation-reviews', false, $plugin_rel_path );
}
add_action('plugins_loaded', 'myplugin_init');

