<?php
function agf_save_reporting_metabox($post_id, $post)
{
    /* Verify the nonce before proceeding. */
    if (!isset($_POST['reporting_meta_box_nonce']) || !wp_verify_nonce($_POST['reporting_meta_box_nonce'], basename(__FILE__)))
        return $post_id;

    /* Get the post type object. */
    $post_type = get_post_type_object($post->post_type);

    /* Check if the current user has permission to edit the post. */
    if (!current_user_can($post_type->cap->edit_post, $post_id))
        return $post_id;

    // !################### Gravity Form Select Field Save ###################
    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_gf_selected_form_value = (isset($_POST['form-select']) ? sanitize_html_class($_POST['form-select']) : ’);
    /* Get the meta value of the custom field key. */
    $meta_value_select = get_post_meta($post_id, 'selected_form_id', true);
    // Updating the selected form value.
    if ($meta_value_select && ’ == $new_gf_selected_form_value) {
        add_post_meta($post_id, 'selected_form_id', $new_gf_selected_form_value, true);
    } /* If the new meta value does not match the old value, update it. */ elseif ($new_gf_selected_form_value != $meta_value_select) {
        update_post_meta($post_id, 'selected_form_id', $new_gf_selected_form_value);
    }


    // !################### Graph Type ###################
    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_graph_type_meta_value = (isset($_POST['graph-select']) ? sanitize_html_class($_POST['graph-select']) : ’);
    /* Get the meta key. */
    $graph_type_meta_key = 'graph_type';
    /* Get the meta value of the custom field key. */
    $graph_type_meta_value = get_post_meta($post_id, $graph_type_meta_key, true);
    /* If a new meta value was added and there was no previous value, add it. */
    if ($graph_type_meta_value && ’ == $new_graph_type_meta_value) {
        add_post_meta($post_id, $graph_type_meta_key, $new_graph_type_meta_value, true);
    }
    /* If the new meta value does not match the old value, update it. */ elseif ($new_graph_type_meta_value != $graph_type_meta_value) {
        update_post_meta($post_id, $graph_type_meta_key, $new_graph_type_meta_value);
    }

    // !################### Selected Role ###################
    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_selected_role_meta_value = (isset($_POST['role-select']) ? sanitize_html_class($_POST['role-select']) : ’);
    /* Get the meta key. */
    $selected_role_meta_key = 'selected_role';
    /* Get the meta value of the custom field key. */
    $selected_role_meta_value = get_post_meta($post_id, $selected_role_meta_key, true);
    /* If a new meta value was added and there was no previous value, add it. */
    if ($selected_role_meta_value && ’ == $new_selected_role_meta_value) {
        add_post_meta($post_id, $selected_role_meta_key, $new_selected_role_meta_value, true);
    }
    /* If the new meta value does not match the old value, update it. */ elseif ($new_selected_role_meta_value != $selected_role_meta_value) {
        update_post_meta($post_id, $selected_role_meta_key, $new_selected_role_meta_value);
    }

    // !################### Saving Color picker ###################
    /* Get the posted data and sanitize it for use as an Email. Email is used to allow for # hex value. */
    $new_color_one_meta_value = (isset($_POST['graph-color-one-picker']) ? filter_var($_POST['graph-color-one-picker'], FILTER_SANITIZE_EMAIL) : ’);
    /* Get the meta key. */
    $color_one_meta_key = 'graph_color_one';
    /* Get the meta value of the custom field key. */
    $color_one_meta_value = get_post_meta($post_id, $color_one_meta_key, true);
    /* If a new meta value was added and there was no previous value, add it. */
    if ($color_one_meta_value && ’ == $new_color_one_meta_value) {
        add_post_meta($post_id, $color_one_meta_key, $new_color_one_meta_value, true);
    }
    /* If the new meta value does not match the old value, update it. */ elseif ($new_color_one_meta_value != $color_one_meta_value) {
        update_post_meta($post_id, $color_one_meta_key, $new_color_one_meta_value);
    }

    // Color Two
    $new_color_two_meta_value = (isset($_POST['graph-color-two-picker']) ? filter_var($_POST['graph-color-two-picker'], FILTER_SANITIZE_EMAIL) : ’);
    $color_two_meta_key = 'graph_color_two';
    $color_two_meta_value = get_post_meta($post_id, $color_two_meta_key, true);
    if ($color_two_meta_value && ’ == $new_color_two_meta_value) {
        add_post_meta($post_id, $color_two_meta_key, $new_color_two_meta_value, true);
    } elseif ($new_color_two_meta_value != $color_two_meta_value) {
        update_post_meta($post_id, $color_two_meta_key, $new_color_two_meta_value);
    }

    // Color Three
    $new_color_three_meta_value = (isset($_POST['graph-color-three-picker']) ? filter_var($_POST['graph-color-three-picker'], FILTER_SANITIZE_EMAIL) : ’);
    $color_three_meta_key = 'graph_color_three';
    $color_three_meta_value = get_post_meta($post_id, $color_three_meta_key, true);

    if ($color_three_meta_value && ’ == $new_color_three_meta_value) {
        add_post_meta($post_id, $color_three_meta_key, $new_color_three_meta_value, true);
    } elseif ($new_color_three_meta_value != $color_three_meta_value) {
        update_post_meta($post_id, $color_three_meta_key, $new_color_three_meta_value);
    }

    // Color Four
    $new_color_four_meta_value = (isset($_POST['graph-color-four-picker']) ? filter_var($_POST['graph-color-four-picker'], FILTER_SANITIZE_EMAIL) : ’);
    $color_four_meta_key = 'graph_color_four';
    $color_four_meta_value = get_post_meta($post_id, $color_four_meta_key, true);

    if ($color_four_meta_value && ’ == $new_color_four_meta_value) {
        add_post_meta($post_id, $color_four_meta_key, $new_color_four_meta_value, true);
    } elseif ($new_color_four_meta_value != $color_four_meta_value) {
        update_post_meta($post_id, $color_four_meta_key, $new_color_four_meta_value);
    }

    // !################### Saving Graph Border Color picker ###################
    /* Get the posted data and sanitize it for use as an Email. Email is used to allow for # hex value. */
    $new_color_one_meta_value = (isset($_POST['graph-border-color-one-picker']) ? filter_var($_POST['graph-border-color-one-picker'], FILTER_SANITIZE_EMAIL) : ’);
    /* Get the meta key. */
    $color_one_meta_key = 'graph_border_color_one';
    /* Get the meta value of the custom field key. */
    $color_one_meta_value = get_post_meta($post_id, $color_one_meta_key, true);
    /* If a new meta value was added and there was no previous value, add it. */
    if ($color_one_meta_value && ’ == $new_color_one_meta_value) {
        add_post_meta($post_id, $color_one_meta_key, $new_color_one_meta_value, true);
    }
    /* If the new meta value does not match the old value, update it. */ elseif ($new_color_one_meta_value != $color_one_meta_value) {
        update_post_meta($post_id, $color_one_meta_key, $new_color_one_meta_value);
    }

    // Color Two
    $new_color_two_meta_value = (isset($_POST['graph-border-color-two-picker']) ? filter_var($_POST['graph-border-color-two-picker'], FILTER_SANITIZE_EMAIL) : ’);
    $color_two_meta_key = 'graph_border_color_two';
    $color_two_meta_value = get_post_meta($post_id, $color_two_meta_key, true);
    if ($color_two_meta_value && ’ == $new_color_two_meta_value) {
        add_post_meta($post_id, $color_two_meta_key, $new_color_two_meta_value, true);
    } elseif ($new_color_two_meta_value != $color_two_meta_value) {
        update_post_meta($post_id, $color_two_meta_key, $new_color_two_meta_value);
    }

    // Color Three
    $new_color_three_meta_value = (isset($_POST['graph-border-color-three-picker']) ? filter_var($_POST['graph-border-color-three-picker'], FILTER_SANITIZE_EMAIL) : ’);
    $color_three_meta_key = 'graph_border_color_three';
    $color_three_meta_value = get_post_meta($post_id, $color_three_meta_key, true);

    if ($color_three_meta_value && ’ == $new_color_three_meta_value) {
        add_post_meta($post_id, $color_three_meta_key, $new_color_three_meta_value, true);
    } elseif ($new_color_three_meta_value != $color_three_meta_value) {
        update_post_meta($post_id, $color_three_meta_key, $new_color_three_meta_value);
    }

    // Color Four
    $new_color_four_meta_value = (isset($_POST['graph-border-color-four-picker']) ? filter_var($_POST['graph-border-color-four-picker'], FILTER_SANITIZE_EMAIL) : ’);
    $color_four_meta_key = 'graph_border_color_four';
    $color_four_meta_value = get_post_meta($post_id, $color_four_meta_key, true);

    if ($color_four_meta_value && ’ == $new_color_four_meta_value) {
        add_post_meta($post_id, $color_four_meta_key, $new_color_four_meta_value, true);
    } elseif ($new_color_four_meta_value != $color_four_meta_value) {
        update_post_meta($post_id, $color_four_meta_key, $new_color_four_meta_value);
    }


    // !################### Selected User Domain ###################
    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_selected_email_domain_meta_value = (isset($_POST['email-domain-select']) ? filter_var($_POST['email-domain-select'], FILTER_SANITIZE_EMAIL) : ’);
    /* Get the meta key. */
    $selected_email_domain_meta_key = 'selected_email_domain';
    /* Get the meta value of the custom field key. */
    $selected_email_domain_meta_value = get_post_meta($post_id, $selected_email_domain_meta_key, true);
    /* If a new meta value was added and there was no previous value, add it. */
    if ($selected_email_domain_meta_value && ’ == $new_selected_email_domain_meta_value) {
        add_post_meta($post_id, $selected_email_domain_meta_key, $new_selected_email_domain_meta_value, true);
    }
    /* If the new meta value does not match the old value, update it. */ elseif ($new_selected_email_domain_meta_value != $selected_email_domain_meta_value) {
        update_post_meta($post_id, $selected_email_domain_meta_key, $new_selected_email_domain_meta_value);
    }


    // // !################### Field Type Array ###################
    // // save field type array
    // $new_field_type_array_meta_value = ( isset( $_POST['field-type-array'] ) ? filter_var( $_POST['field-type-array'], FILTER_SANITIZE_EMAIL ) : ’ );
    // $field_type_array_meta_key = 'field_type_array';
    // $field_type_array_meta_value = get_post_meta( $post_id, $field_type_array_meta_key, true );
    // if ( $field_type_array_meta_value && ’ == $new_field_type_array_meta_value ){
    // add_post_meta( $post_id, $field_type_array_meta_key, $new_field_type_array_meta_value, true );
    // }
    // elseif ( $new_field_type_array_meta_value != $field_type_array_meta_value ){
    // update_post_meta( $post_id, $field_type_array_meta_key, $new_field_type_array_meta_value );
    // }

    // !################### Selected Field Types ###################
    // save selected field types
    $new_selected_field_types_meta_value = (isset($_POST['selected-field-types']) ? array_map('strip_tags', $_POST['selected-field-types']) : ’);
    $selected_field_types_meta_key = 'selected_field_types';
    $selected_field_types_meta_value = get_post_meta($post_id, $selected_field_types_meta_key, true);
    if ($selected_field_types_meta_value && ’ == $new_selected_field_types_meta_value) {
        add_post_meta($post_id, $selected_field_types_meta_key, $new_selected_field_types_meta_value, true);
    } elseif ($new_selected_field_types_meta_value != $selected_field_types_meta_value) {
        update_post_meta($post_id, $selected_field_types_meta_key, $new_selected_field_types_meta_value);
    }


    // filter_var( [""], FILTER_SANITIZE_EMAIL);
    // update_post_meta( $post_id, "my_select_key", "", true );
    if (isset($_POST['my-select'])) {
        update_post_meta($post_id, 'my_select_key', array_map('sanitize_text_field', $_POST["my-select"]));
    }
}
