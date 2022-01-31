<?php
function agf_average_score_short_code($atts, $content = null){
    $a = shortcode_atts(array(
        'id' => null,
    ), $atts );
  
    // if user is printing pdf then do not show the content from this short code
    if($_REQUEST['pdf_print'] == 'true'){
        return;
    }
    $post_id = $atts['id'];
    $post = get_post($post_id);
    $post_meta = get_post_meta($post_id);
    $scored_data = get_post_meta($post_id, 'scored_entries', true);
    // $user_id = get_current_user_id();
    $categories_names = array();
    $current_logged_user_id = get_current_user_id();
    $current_logged_user_data = get_user_by('id', $current_logged_user_id);
    $current_logged_user_email = $current_logged_user_data->data->user_email;
    
    ob_start();
    echo '<div class="agf-average-score-container">';
    echo '<h2>H2 average scores</h2>';
    echo '</div>';

    echo '<body width="100px" height="100px">
        <div height="100px" width="100px"><canvas id="myChart" height="40vh" width="80vw"></div>
    </body>';

    return ob_get_clean();
}