<?php



    /* Verify the nonce before proceeding. */
    if (!isset($_POST['agf_select_form_nonce']) || !wp_verify_nonce($_POST['agf_select_form_nonce'], 'agf_multi_select_form_nonce_action'))
        return $post_id;

    /* Get the post type object. */
    $post_type = get_post_type_object($post->post_type);

    /* Check if the current user has permission to edit the post. */
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;


    // !################### multi-select-field save ###################
    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_multi_selected_form_meta_value = (isset($_POST['agf-multi-select-forms']) ? array_map('strip_tags', $_POST['agf-multi-select-forms']) : ’);

    /* Get the meta value of the custom field key. */
    $selected_form_meta_key = 'multi_selected_forms_ids';

    /* If a new meta value was added and there was no previous value, add it. */
    $selected_form_meta_value = get_post_meta($post_id, $selected_form_meta_key, true);
    // if (!$selected_form_meta_value) {
    //     add_post_meta($post_id, $selected_form_meta_key, $new_multi_selected_form_meta_value, true);
    // }
    /* If the new meta value does not match the old value, update it. */ 
    // if ($new_selected_role_meta_value != $selected_role_meta_value) {
    // }
    update_post_meta($post_id, $selected_form_meta_key, $new_multi_selected_form_meta_value);