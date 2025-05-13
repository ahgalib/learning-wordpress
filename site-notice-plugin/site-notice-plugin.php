<?php
/*
Plugin Name: Site Notice Plugin
Plugin URI: https://notice.com/
Description: Display a custom notice message on the site header.
Version: 1.0
Author: Galibba
Author URI: https://galibba.com/
License: GPL2
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Activation Hook
register_activation_hook(__FILE__, 'site_notice_activate');
function site_notice_activate()
{
    add_option('site_notice_message', 'Welcome to my website!'); // Default notice
}

// Deactivation Hook
register_deactivation_hook(__FILE__, 'site_notice_deactivate');
function site_notice_deactivate()
{
    delete_option('site_notice_message'); // Clean up
}

// Add Admin Menu
add_action('admin_menu', 'site_notice_add_admin_menu');

function site_notice_add_admin_menu()
{
    add_menu_page(
        'Site Notice Settings',
        'Site Notice',
        'manage_options',
        'site-notice-settings',
        'site_notice_settings_page_html',
        'dashicons-megaphone', // Cool icon!
        100
    );
}

// Admin Page HTML
function site_notice_settings_page_html()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['site_notice_message'])) {
        update_option('site_notice_message', sanitize_text_field($_POST['site_notice_message']));
        echo '<div class="updated"><p>Notice updated!</p></div>';
    }

    $current_message = get_option('site_notice_message');

?>
    <div class="wrap">
        <h1>Site Notice Settings</h1>
        <form method="post">
            <label for="site_notice_message">Notice Message:</label><br>
            <textarea name="site_notice_message" rows="5" cols="50"><?php echo esc_textarea($current_message); ?></textarea><br><br>
            <input type="submit" class="button button-primary" value="Save Notice">
        </form>
    </div>
<?php
}


// Show notice on site header
add_action('wp_footer', 'site_notice_display_message');

function site_notice_display_message()
{
    // If cookie is set, don't show notice
    if (isset($_COOKIE['site_notice_dismissed'])) {
        return;
    }

    $message = get_option('site_notice_message');

    if (!empty($message)) {
        echo '<div class="site-notice-bar" style="position: fixed; bottom: 0; width: 100%; background: #ffcc00; color: #000; text-align: center; padding: 10px; z-index:9999;">' . esc_html($message) .'<span class="site-notice-close">&times;</span></div>';
    }
}

add_action('wp_enqueue_scripts', 'site_notice_enqueue_assets');

function site_notice_enqueue_assets()
{
    wp_enqueue_style('site-notice-style', plugin_dir_url(__FILE__) . 'css/site-notice.css');
    wp_enqueue_script('site-notice-script', plugin_dir_url(__FILE__) . 'js/site-notice.js', [], false, true);
}
