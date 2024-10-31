<?php
/*
 Plugin name: Next Notification Bar
 Plugin URI:  https://wordpress.org/plugins/next-notification-bar
 Description: Easily enable a notification bar on your site with modern and clean UI.
 Version:     1.0.1
 Author:      Thien Nguyen
 Author URI:  https://thien.dev
 License:     GPL2
 License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

namespace NextNotificationBar;

require_once __DIR__ . '/vendor/autoload.php';

Config::add('version', '1.0.1');
Config::add('plugin_path', plugin_dir_path(__FILE__));
Config::add('plugin_url', plugin_dir_url(__FILE__));
Config::add('plugin_basename', plugin_basename(__FILE__));

new EnqueueAssets;
new Settings;
new NotificationBar;

/**
 * Register rest API endpoints
 */
add_action('rest_api_init', function () {
	$api = new Api();
	$api->register_routes();
});

/**
 * Add more custom plugin action links.
 */
add_filter( 'plugin_action_links_' . Config::get('plugin_basename'), function ($links) {
	$plugin_links = [];
	$plugin_links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=next-notification-bar') ) .'">' . esc_html__( 'Settings' ) . '</a>';
	return $plugin_links + $links;
}, 100 );
