<?php


namespace NextNotificationBar;


class Utility
{
	public static function get_template(string $template_name, $data = []): void
	{
		$template_dir = 'templates';
		$template_path = Config::get('plugin_path') . '/' . $template_dir . '/' . $template_name;

		if (!file_exists($template_path)) {
			throw new \Exception("$template_path does not exist");
		}

		if (is_array($data)) {
			extract($data);
		}

		include $template_path;
	}

	public static function convert_styles($styles = []): string {
		$styles_str = '';
		foreach ($styles as $rule => $value) {
			$styles_str .= "$rule:$value;";
		}

		return $styles_str;
	}
}
