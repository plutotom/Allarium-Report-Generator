<?php 
//! This is to save question categories

    /* Verify the nonce before proceeding. */
    if (!isset($_POST['agf_select_form_nonce']) || !wp_verify_nonce($_POST['agf_select_form_nonce'], 'agf_multi_select_form_nonce_action'))
        return $post_id;

    /* Get the post type object. */
    $post_type = get_post_type_object($post->post_type);

    /* Check if the current user has permission to edit the post. */
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;
   


    // !################### Category Save ###################
    /* Get the meta value of the custom field key. */
    $category_meta_key = 'category_data';

    /* If a new meta value was added and there was no previous value, add it. */
    // $category = get_post_meta($post_id, $category_meta_key, true);
    // if(!add_post_meta( $post_id, $category_meta_key, ["question-labe" => [], "question-checkbox" => [], "category-title" => []], true )){
    //         $data = $category;
    //     if(isset($_POST["question-label"])) :
    //         // update_post_meta($post->ID, 'question-label', $_POST["question-label"]);
    //         $data["question-label"] = $_POST["question-label"];
    //     endif;
        
    //     if(isset($_POST["question-checkbox"])) :
    //         // update_post_meta($post->ID, 'question-label', $_POST["question-label"]);
    //         $data["question-checkbox"] = $_POST["question-checkbox"];
    //     endif;
        
    //     if(isset($_POST["category-title"])) :
    //         // update_post_meta($post->ID, 'question-label', $_POST["question-label"]);
    //     endif;
    //     $data["category-title"] = $_REQUEST["category-title"];

    //     // foreach item in $_POST["question-label"]
        


    //     update_post_meta($post->ID, $category_meta_key, $data);
            
    // }
    
// }