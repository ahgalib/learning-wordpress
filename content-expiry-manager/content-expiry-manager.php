<?php

/**
 * Plugin Name: Content Expiry Manager
 * Description: Allows you to set an expiry date for posts and take action when expired.
 * Version: 1.0
 * Author: Galibba
 * Author URI: https://galibba.com/
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// Include core plugin files (we'll add these next)
require_once plugin_dir_path(__FILE__) . 'includes/class-cem-loader.php';
