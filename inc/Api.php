<?php

namespace NextNotificationBar;

class Api
{
	private $namespace = '';

	public function __construct()
	{
		$this->namespace = 'next-notification-bar/v1';
	}

	public function register_routes(): void
	{
		register_rest_route($this->namespace, '/notification-bar', [
			'methods' => \WP_REST_Server::READABLE,
			'callback' => [$this, 'show'],
			'permission_callback' => [$this, 'get_private_permission'],
		]);

		register_rest_route($this->namespace, '/notification-bar/preview', [
			'methods' => \WP_REST_Server::CREATABLE,
			'callback' => [$this, 'preview'],
			'permission_callback' => [$this, 'get_private_permission'],
		]);

		register_rest_route($this->namespace, '/notification-bar/save', [
			'methods' => \WP_REST_Server::CREATABLE,
			'callback' => [$this, 'save'],
			'permission_callback' => [$this, 'get_private_permission'],
		]);
	}

	public function show()
	{
		$data = NotificationBar::get_data();

		return new \WP_REST_Response($data);
	}

	public function preview(\WP_REST_Request $request)
	{
		$data = $request->get_params();
		NotificationBar::save_preview_data($data);

		return new \WP_REST_Response([
			'previewUrl' => NotificationBar::get_preview_url(),
		]);
	}

	public function save(\WP_REST_Request $request)
	{
		$data = $request->get_params();
		NotificationBar::save_data($data);

		return new \WP_REST_Response(null, 204);
	}

	public function get_private_permission()
	{
		return current_user_can('manage_options');
	}
}
