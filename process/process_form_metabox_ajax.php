<?php

function add_question_category_process(){
    print_r("Processing ajax request to add category");
    // print_r($_POST);

    // $output['status'] = 2; // 2 == success 1 == fail
    wp_send_json( $output ); // sends a response back to the ajax call
    // wp_die();
};

// gets all form questions and returns them
function get_all_form_questions_process(){
    // get gravity forms
    $forms = GFAPI::get_forms();
    // get post id
    $post_id = $_POST['post_id'];


    // $categories_data  = get_post_meta( $post_id, 'categories', true );
    // $categories_data = empty($recipe_data) ? [] : $recipe_data;
    // update_post_meta( $post_id, 'category_data', $categories_data );

    $output['status'] = 2; // 2 == success 1 == fail
    $output['all_forms'] = $forms; 
    
    wp_send_json( $output ); // sends a response back to the ajax call and does wp_die();
};