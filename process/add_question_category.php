<?php

function add_question_category_process(){
    print_r("Processing ajax request to add category");
    // print_r($_POST);

    // $output['status'] = 2; // 2 == success 1 == fail
    // wp_send_json( $output ); // sends a response back to the ajax call
    wp_die(); 
};