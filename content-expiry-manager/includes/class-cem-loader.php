<?php

class CEM_Loader
{
    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
    }

    public function init()
    {
        require_once plugin_dir_path(__FILE__) . 'class-cem-admin.php';
        require_once plugin_dir_path(__FILE__) . 'class-cem-cron.php';
        require_once plugin_dir_path(__FILE__) . 'class-cem-settings.php';

        new CEM_Admin();
        new CEM_Cron();
        new CEM_Settings();
    }
}

new CEM_Loader();
