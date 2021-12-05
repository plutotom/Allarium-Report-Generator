<?php

function agf_register_settings()
{
    // /**
    //  * Adds a submenu page under a custom post type parent.
    //  */
    function books_register_ref_page()
    {
        add_submenu_page(
            'edit.php?post_type=agfreport',
            __('agf Report Schema', 'textdomain'),
            __('New Schema', 'textdomain'),
            'manage_options',
            'agfReport-schema',
            'agfReport_ref_page_callback'
        );
    }

    // /**
    //  * Display callback for the submenu page.
    //  */
    function agfReport_ref_page_callback()
    {
?>
        <div class="wrap">
            <h1><?php _e('Page Title', 'textdomain'); ?></h1>
            <p><?php _e('Helpful stuff here', 'textdomain'); ?></p>
        </div>
<?php
    }
    add_action('admin_menu', 'books_register_ref_page');
}
