<?php

namespace NextNotificationBar;

class Settings
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'register_menu']);
    }

    public function register_menu()
    {
        add_submenu_page(
            'options-general.php',
            esc_html__('Next Notification Bar', 'next-nb'),
            esc_html__('Next Notification Bar', 'next-nb'),
            'manage_options',
            'next-notification-bar',
            [$this, 'render']
        );
    }

    public function render()
    {
		echo '<div id="next-notification-bar-settings"></div>';
    }
}
