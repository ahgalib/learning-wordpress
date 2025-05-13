<?php

class CEM_Admin
{

    public function __construct()
    {
        add_action('add_meta_boxes', [$this, 'add_expiry_meta_box']);
        add_action('save_post', [$this, 'save_expiry_meta_box_data']);
    }

    // Add Meta Box
    public function add_expiry_meta_box()
    {
        add_meta_box(
            'cem_expiry_meta_box',          // ID
            'Content Expiry Settings',      // Title
            [$this, 'render_meta_box'],     // Callback
            ['post', 'page'],               // Post types
            'side',                         // Context (side or normal)
            'default'                       // Priority
        );
    }

    // Render Meta Box HTML
    public function render_meta_box($post)
    {
        // Add a nonce field for security
        wp_nonce_field('cem_save_expiry_date', 'cem_expiry_nonce');

        // Get the saved expiry date (if any)
        $expiry_date = get_post_meta($post->ID, '_cem_expiry_date', true);
?>
        <label for="cem_expiry_date">Expiry Date:</label>
        <input type="date" id="cem_expiry_date" name="cem_expiry_date" value="<?php echo esc_attr($expiry_date); ?>" />
<?php
    }

    // Save the expiry date when the post is saved
    public function save_expiry_meta_box_data($post_id)
    {
        // Verify nonce
        if (!isset($_POST['cem_expiry_nonce']) || !wp_verify_nonce($_POST['cem_expiry_nonce'], 'cem_save_expiry_date')) {
            return;
        }

        // Avoid autosaves or revisions
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check user permission
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save the expiry date
        if (isset($_POST['cem_expiry_date'])) {
            $date = sanitize_text_field($_POST['cem_expiry_date']);
            update_post_meta($post_id, '_cem_expiry_date', $date);
        } else {
            delete_post_meta($post_id, '_cem_expiry_date');
        }
    }
}

new CEM_Admin();
