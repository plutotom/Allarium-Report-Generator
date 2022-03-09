<?php
// This is used to enqueue styles for the admin area.


// registering javascript script.
function agf_enqueue_styles()
{
    // get current admin screen, or null
    $screen = get_current_screen();
    // verify admin screen object
    // if (is_object($screen)) {
    // enqueue only for specific post types
    // if (in_array($screen->post_type, [ 'agfreport'])) {
    // enqueue script
    wp_enqueue_style(
        'agf_bootstrap_list_questions_style',
        'https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css',
    );
    wp_enqueue_style("agf_list_question_styles", plugin_dir_url(__FILE__) . "../styles/list_questions_styles.css");
}
//     }
// }