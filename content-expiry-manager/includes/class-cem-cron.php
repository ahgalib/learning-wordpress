<?php

class CEM_Cron
{
    public function __construct()
    {
        // Schedule cron event on plugin activation
        register_activation_hook(__FILE__, [$this, 'schedule_cron']);

        // Clear cron on plugin deactivation
        register_deactivation_hook(__FILE__, [$this, 'clear_cron']);

        // Hook into our custom cron action
        add_action('cem_check_expired_posts', [$this, 'check_expired_posts']);

        // In case it's not scheduled yet
        if (!wp_next_scheduled('cem_check_expired_posts')) {
            wp_schedule_event(time(), 'hourly', 'cem_check_expired_posts');
        }
    }

    // Schedule the cron event
    public function schedule_cron()
    {
        if (!wp_next_scheduled('cem_check_expired_posts')) {
            wp_schedule_event(time(), 'hourly', 'cem_check_expired_posts');
        }
    }

    // Clear the cron event
    public function clear_cron()
    {
        $timestamp = wp_next_scheduled('cem_check_expired_posts');
        if ($timestamp) {
            wp_unschedule_event($timestamp, 'cem_check_expired_posts');
        }
    }

    // Logic to check and expire posts
    public function check_expired_posts()
    {
        $today = date('Y-m-d');

        $query = new WP_Query([
            'post_type'      => ['post', 'page'],
            'post_status'    => 'publish',
            'meta_key'       => '_cem_expiry_date',
            'meta_value'     => $today,
            'meta_compare'   => '<=',
            'posts_per_page' => -1
        ]);

        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                wp_update_post([
                    'ID'          => $post->ID,
                    'post_status' => 'draft'
                ]);
            }
        }

        wp_reset_postdata();
    }
}

new CEM_Cron();