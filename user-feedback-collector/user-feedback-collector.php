<?php

/**
 * Plugin Name: User Feedback Collector
 * Description: Collects user feedback via AJAX, with image upload support.
 * Version: 1.0
 * Author: Your Name
 */

if (! defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Define constants
define('UFC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('UFC_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include core files
// require_once UFC_PLUGIN_DIR . 'includes/class-feedback-db.php';       // Will handle DB setup
// require_once UFC_PLUGIN_DIR . 'includes/class-feedback-handler.php'; // Will handle AJAX
// require_once UFC_PLUGIN_DIR . 'includes/class-feedback-admin.php';   // Admin UI

// Add a function to create the database table
function ufc_create_feedback_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'user_feedback';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        user_id bigint(20) UNSIGNED NOT NULL,
        feedback_text text NOT NULL,
        image_url varchar(255) DEFAULT '' NOT NULL,
        submitted_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Register activation hook to create the database table
register_activation_hook(__FILE__, 'ufc_create_feedback_table');

// Shortcode to display the form
function ufc_render_feedback_form()
{
    ob_start();
    include UFC_PLUGIN_DIR . 'templates/feedback-form.php';
    return ob_get_clean();
}
add_shortcode('user_feedback_form', 'ufc_render_feedback_form');

// Enqueue frontend scripts
function ufc_enqueue_scripts()
{
    if (is_singular() && has_shortcode(get_post()->post_content, 'user_feedback_form')) {
        wp_enqueue_script(
            'ufc-feedback-js',
            UFC_PLUGIN_URL . 'assets/js/ufc-form.js',
            [],
            '1.0',
            true
        );

        wp_localize_script('ufc-feedback-js', 'ufc_ajax_obj', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
}
add_action('wp_enqueue_scripts', 'ufc_enqueue_scripts');


add_action('wp_ajax_ufc_submit_feedback', 'ufc_handle_feedback_submission');
add_action('wp_ajax_nopriv_ufc_submit_feedback', 'ufc_handle_feedback_submission');

function ufc_handle_feedback_submission()
{
    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    echo $name . ' ' . $email . ' ' . $message; // Debugging line
    die;
    if (empty($name) || empty($email) || empty($message)) {
        wp_send_json_error('All fields are required.');
    }

    // You can insert into database here (next step)
    // For now, just simulate success
    wp_send_json_success('Feedback received successfully.');
}
