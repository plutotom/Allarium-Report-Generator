<?php

function agf_short_code_score_current($atts)
{
    if ($atts['id'] == '' || $atts['id'] == null) {
        // console_log("Please add a valid post ID to short code to agfTable short code");
        return null;
    }


    ob_start();
    $post_id = $atts['id'];
    $entry_id = $atts['entry_id'];
    $post = get_post($post_id);
    $post_meta = get_post_meta($post_id);
    $scored_data = get_post_meta($post_id, 'scored_entries', true);
    $user_id = get_current_user_id();
    $categories_names = array();

    $current_logged_user_id = get_current_user_id();
    $current_logged_user_data = get_user_by('id', $current_logged_user_id);
    $current_logged_user_email = $current_logged_user_data->data->user_email;
?>

    <table class="table table-striped table-bordered table-hover" id="html-table">
        <thead>
            <tr>
                <?php
                foreach ($scored_data as $user_key => &$user) {
                    foreach ($user['forms'] as $form_key => &$form) {
                        foreach ($form['entries'] as $entry_key => &$entry) {
                            foreach ($entry['categories'] as $category_key => &$category) {
                                !in_array($category_key, $categories_names) ? $categories_names[] = $category_key : null;
                            }
                        }
                    }
                }
                ?>
                <th>Email</th>
                <!-- <th>User Id</th> -->
                <!-- <th>Form Id</th> -->
                <th>Form Name</th>
                <!-- <th>Entry Id</th> -->
                <?php foreach ($categories_names as $category_name) {
                    echo "<th>" . $category_name . "</th>";
                } ?>
            </tr>
        </thead>
        <tbody>
        <?php



        foreach ($scored_data as $user_email => &$user) {
            if (strtoupper($current_logged_user_email) == strtoupper($user_email)) {
                foreach ($user['forms'] as $form_key => &$form) {
                    foreach ($form['entries'] as $entry_key => &$entry) {
                        echo "<tr>";
                        echo "<td>" . $user_email . "</td>";
                        // if(!empty($user_email)){
                        //     $user_id = get_user_by('email', $user_email)->ID;
                        //     if(!empty($user_id)){
                        //         echo "<td>".$user_id."</td>";
                        //     }else{
                        //         echo "<td></td>";
                        //     }
                        // }
                        // echo "<td>".$form["form_id"]."</td>";
                        // get gravity form by id
                        $form_name = GFAPI::get_form($form["form_id"])['title'];
                        echo "<td>" . $form_name . "</td>";
                        // echo "<td>".$entry["entry_id"]."</td>";
                        foreach ($categories_names as $category_name) {
                            if (isset($entry['categories'][$category_name])) {
                                echo "<td>" . $entry['categories'][$category_name] . "</td>";
                            } else {
                                echo "<td></td>";
                            }
                        }
                        echo "</tr>";
                    }
                }
            }
        }

        echo '</tbody>';
        echo '</table>';
        return ob_get_clean();
    }
