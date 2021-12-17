<?php
// This file is used to enqueue scripts for the admin area.


// registering javascript script.
function agf_get_post_data_list_questions_metabox_script()
{
    // get current admin screen, or null
    $screen = get_current_screen();
    // verify admin screen object
    if (is_object($screen)) {
        // enqueue only for specific post types
        if (in_array($screen->post_type, [ 'agfreport'])) {
            // enqueue script
            wp_enqueue_script('agf_main_js', plugin_dir_url(__FILE__) . 'js/main.js', ['jquery']);

            // localize script, create a custom js object
            // this will enqueue the script and append the url to a javascript variable named agf_list_questions_metabox_obj
            wp_localize_script(
                'agf_main_js', 
                'agf_list_questions_metabox_obj', // name of javascript variable that url will be append to.
                    [
                        'url'           => admin_url('admin-ajax.php'),
                        'post_data'     => $post_data = get_post_meta(get_the_id()),

                    ]
            );
            
        }
    }
}
add_action('admin_enqueue_scripts', 'agf_get_post_data_list_questions_metabox_script');