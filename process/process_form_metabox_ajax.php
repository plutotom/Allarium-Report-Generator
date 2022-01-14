<?php

function agf_add_question_category_process(){
    print_r("Processing ajax request to add category");
    // print_r($_POST);

    // $output['status'] = 2; // 2 == success 1 == fail
    wp_send_json( $output ); // sends a response back to the ajax call
    // wp_die();
};

// gets all form questions and returns them
function agf_update_post_meta_process(){    
    $post_id = $_POST['post_id'];
    if(!wp_verify_nonce($_POST['nonce'], 'agf_category_nonce')){
        print_r("failed to verify nonce");
        echo $output["status"] = 1;
        return $post_id;
    }
    
    // Getting previous data from post meta
    $category_data  = get_post_meta( $post_id, 'category_data', true );

    if(empty($category_data)){
        print_r("No categories found, creating category data field");
        add_post_meta( $post_id, "category_data", 
        [
            "question_label" => [],
            "question_checkbox" => [],
            "category_title" => []
        ],
         true );
    }else{
        print_r("Categories found");
        $category_data = maybe_unserialize($category_data);
    }
  
    print_r("Processing ajax request to update post meta");
    $category_data = ["category_title" => "title set from within", "category_questions" => ["question 1", "question 2"]];
    update_post_meta( $post_id, 'category_data', $_POST["data"] );


    $output['status'] = 2; // 2 == success, 1 == fail
    echo $output;
    // wp_send_json( $output ); // sends a response back to the ajax call and does wp_die();
};