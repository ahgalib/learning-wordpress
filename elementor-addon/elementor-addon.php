<?php

/**
 * Plugin Name: Elementor Addon
 * Description: Simple hello world widgets for Elementor.
 * Version:     1.0.0
 * Author:      Elementor Developer
 * Author URI:  https://developers.elementor.com/
 * Text Domain: elementor-addon
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
 */

function register_hello_world_widget($widgets_manager)
{

    require_once(__DIR__ . '/widgets/card-list-widget.php');


    $widgets_manager->register(new \Card_List_Widget());

}
add_action('elementor/widgets/register', 'register_hello_world_widget');



function card_list_enqueue_assets()
{
    wp_enqueue_style('card-list-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('card-list-script', plugin_dir_url(__FILE__) . 'assets/js/script.js', [], false, true);
}
add_action('wp_enqueue_scripts', 'card_list_enqueue_assets');