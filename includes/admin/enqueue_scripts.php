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
            $post_data = get_post_meta(get_the_id());
            $post_data['multi_selected_forms_ids'] = maybe_unserialize($post_data["multi_selected_forms_ids"][0]);
            $post_data['category_data'] = maybe_unserialize($post_data["category_data"][0]);
            $post_id = get_the_id();
            $forms = GFAPI::get_forms();
            $entries = [];
            foreach($forms as $form ){
                $form_id = $form['id'];
                $entries[$form['title']] = GFAPI::get_entries( $form_id );
            }
            $agf_nonce = wp_create_nonce('agf_category_nonce');
            // localize script, create a custom js object
            // this will enqueue the script and append the url to a javascript variable named agf_list_questions_metabox_obj
            wp_localize_script(
                'agf_main_js', 
                'agf_list_questions_metabox_obj', // name of javascript variable that url will be append to.
                    [
                        'nonce'         => $agf_nonce,
                        'ajax_url'      => admin_url('admin-ajax.php'),
                        'post_data'     => $post_data,
                        'post_id'       => $post_id,
                        'all_forms'     => $forms,
                        'all_entries'   => $entries,
                    ]
            );
            
        }
    }
}