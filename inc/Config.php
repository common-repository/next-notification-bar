<?php

namespace NextNotificationBar;

class Config
{
	private static $config = [];

	public static function add(string $key, $value): void {
		self::$config[$key] = $value;
	}

	public static function get(string $key, $default = null) {
		if (array_key_exists($key, self::$config)) {
			return self::$config[$key];
		}

		return $default;
	}
}
