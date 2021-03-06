<?php



function agf_score_entries()
{
    $output["status"] = 1; // 2 == success, 1 == fail
    $post_id = $_POST['post_id'];


    if (!wp_verify_nonce($_POST['nonce'], 'agf_category_nonce')) {
        $output["error_message"] = "failed to verify nonce";
    }
    // get post meta data
    $category_data  = get_post_meta($post_id, 'category_data', true);
    $form_ids  = get_post_meta($post_id, 'multi_selected_forms_ids', true);
    $scored_entries  = get_post_meta($post_id, 'scored_entries', true);

    $scoring_schema = [
        "glikertcol2079ce3b4" => 0, // completely disagree
        "glikertcol2afb99d83" => 1, // Mostly disagree
        "glikertcol2c8b03172" => 2, // Somewhat Disagree
        "glikertcol2705122be" => 3, // Somewhat Agree
        "glikertcol297044e96" => 4, // Mostly Agree
        "glikertcol25100bcbb" => 5, // Completely Agree
        "glikertcol25156cc64" => null, // N/A
    ];
    $scored_obj = [];
    $form_index = 0;
    // Agf_Helper_Class::console_log($form_ids);
    foreach ($form_ids as $form_id) {
        $entry_index = 0;
        // get entries and append to array
        $current_form_entries = GFAPI::get_entries($form_id);
        foreach ($current_form_entries as $entry) {
            $user_email = "";
            $personal_score = [];
            $entry_id = $entry['id'];
            // getting email address


            foreach ($entry as $field_id => $entry_value) {
                // returns the names of the categories the question belongs too if the field_id and the form_id match. 
                // if the question belongs to a category then add the question value to the category array to be scored.
                $category_names = Agf_Helper_Class::sort_by_categories($field_id, $form_id, $category_data);

                // [cat_name_1, cat_name_2]
                if ($category_names != []) {

                    foreach ($entry as $field_id => $val) {
                        if (strpos($val, '@')) {
                            $user_email = $val;
                        }
                    }
                    if (empty($user_email)) {
                        $user_email = get_user_by('id', $entry["created_by"])->user_email;
                    }

                    foreach ($category_names as $category_name) {
                        // if scoring_schema includes entry value then add to array
                        // This is only for survey questions, they have a value  that looks like this: "glikertcol2079ce3b4" 
                        // and that value represents a score. See $scoring_schema.
                        if (array_key_exists($entry_value, $scoring_schema)) {
                            $entry_value = $scoring_schema[$entry_value];
                            $personal_score[$category_name][] = $entry_value;
                        } else {
                            $personal_score[$category_name][] = $entry_value;
                        }
                    }
                }
            }
            if ($user_email != "" || !empty($user_email)) {
                $scored_obj[$user_email]["forms"][$form_index]["entries"][$entry_index]["categories"] = $personal_score;
                $scored_obj[$user_email]["forms"][$form_index]["entries"][$entry_index]["entry_id"] = $entry_id;
                $scored_obj[$user_email]["forms"][$form_index]["form_id"] = $form_id;
                $entry_index += 1;
            }
        } // end foreach entry
        if ($user_email != "" || !empty($user_email)) {
            $scored_obj[$user_email]["forms"][$form_index]["form_id"] = $form_id;
            $form_index += 1;
        }
    } // end loop for each form id

    // if($user_email != "" || !empty($user_email)){
    foreach ($scored_obj as $user_key => &$user) {
        foreach ($user['forms'] as $form_key => &$form) {
            if (!empty($form['entries'])) {
                foreach ($form['entries'] as $entry_key => &$entry) {
                    foreach ($entry['categories'] as $category_key => &$category) {
                        // $entry['categories'][$category_key] = array_sum($category);
                        $scored_obj[$user_key]["forms"][$form_key]["entries"][$entry_key]["categories"][$category_key] = round(array_sum($category) / count($category), 2);
                    }
                }
            }
        }
    }
    // }

    // update post meta data
    update_post_meta($post_id, 'scored_entries', $scored_obj);

    header('Content-Type: application/json');
    echo json_encode($scored_obj, JSON_PRETTY_PRINT);

    // wp_send_json( $scored_obj ); // sends a response back to the ajax call and does wp_die();
    wp_die(); // this is required to terminate immediately and return a proper response
}
