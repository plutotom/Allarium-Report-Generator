<?php

function agf_score_entries(){
    $output["status"] = 1; // 2 == success, 1 == fail
    $post_id = $_POST['post_id'];
    if(!wp_verify_nonce($_POST['nonce'], 'agf_category_nonce')){
        $output["error_message"] = "failed to verify nonce";
        echo $output;
        return $post_id;
    }

    Agf_Helper_Class::console_log( $_POST );
    
}