<?php

namespace NextNotificationBar;

class NotificationBar
{
	private static $preview_param = 'preview-notification-bar';
	private static $nonce_action = 'preview-notification-bar';
	private static $option_key = '_next_nb';
	private static $default_data = [
		'content' => 'Your awesome notification goes here. <strong>HTML</strong> is <em>allow</em>.',
		'showButton' => true,
		'buttonText' => 'Get it now!',
		'buttonLink' => '',
		'styles' => [
			'background' => '#E63946',
			'color' => '#ffffff',
			'buttonBackground' => '#F1FAEE',
			'buttonColor' => '#1a202c',
		],
		'position' => 'fixed_top',
		'alignment' => [
			'value' => 'alignment-center',
			'justifyContent' => 'center'
		],
		'width' => 1200,
		'height' => 60,
		'settings' => [
			'status' => 'draft',
			'displayOn' => 'all',
			'closeButton' => false,
		],
	];

	public function __construct()
	{
		add_action('wp_head', [__CLASS__, 'display_preview']);
		add_action('wp_head', [__CLASS__, 'display_publish']);
	}

	public static function is_preview(): bool
	{
		if (!isset($_GET[self::$preview_param])) {
			return false;
		}

		$nonce =  $_GET[self::$preview_param];

		return wp_verify_nonce($nonce, self::$nonce_action);
	}

	public static function get_preview_url(): string
	{
		$nonce = wp_create_nonce(self::$nonce_action);
		return add_query_arg(self::$preview_param, $nonce, home_url('/'));
	}

	public static function save_preview_data($data): void
	{
		set_transient(self::$option_key, $data);
	}

	public static function save_data($data): void {
		update_option(self::$option_key, $data);
	}

	public static function get_preview_data(): array
	{
		return get_transient(self::$option_key) ?: [];
	}

	public static function get_data(): array
	{
		return get_option(self::$option_key) ?: self::$default_data;
	}

	public static function get_settings(): array
	{
		$options = self::get_data();
		return $options['settings'] ?: [];
	}

	public static function render($data = []): void
	{
		Utility::get_template('notification-bar.php', ['data' => $data]);
	}

	public static function display_preview(): void {
		if (!self::is_preview()) {
			return;
		}

		if (empty(self::get_preview_data())) {
			return;
		}

		$data = self::get_preview_data();
		$data['is_preview'] = true;

		self::render($data);
	}

	public static function display_publish(): void {
		if (self::is_preview()) {
			return;
		}

		$settings = self::get_settings();
		if ($settings['status'] === 'draft') {
			return;
		}

		$data = self::get_data();
		$data['is_preview'] = false;

		$display_on = $settings['displayOn'];
		switch ($display_on) {
			case 'all':
				self::render($data);
				break;
			case 'homepage';
				if (is_home()) {
					self::render($data);
				}
				break;
			case 'post':
			case 'page':
				if (is_singular($display_on)) {
					self::render($data);
				}
				break;
			default:
				//
		}

	}
}
