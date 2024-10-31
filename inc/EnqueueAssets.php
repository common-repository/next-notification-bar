<?php

namespace NextNotificationBar;

class EnqueueAssets
{
	public function __construct()
	{
		add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
		add_action('wp_enqueue_scripts', [$this, 'front_scripts']);
	}

	public function admin_scripts()
	{
		if (isset($_GET['page']) && $_GET['page'] === 'next-notification-bar') {
			wp_enqueue_script(
				'nnb-settings',
				Config::get('plugin_url') . '/dist/admin.js',
				null,
				Config::get('version'),
				true
			);

			wp_localize_script('nnb-settings', 'nextNotificationBar', [
				'baseURL' => home_url('/wp-json/next-notification-bar/v1'),
				'nonce' => wp_create_nonce('wp_rest')
			]);

			wp_enqueue_style(
				'nnb-settings',
				Config::get('plugin_url') . '/dist/admin.css',
				null,
				Config::get('version'),
				'all'
			);
		}
	}

	public function front_scripts()
	{
		wp_enqueue_script(
			'nnb-front',
			Config::get('plugin_url') . '/js/front.js',
			null,
			Config::get('version'),
			true
		);
	}
}
