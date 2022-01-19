<?php
function agf_short_code_table($atts)
{
    // * ################################# Getting meta data and entries #################################
    ob_start();

    $post_id = $atts['id'];
    $post = get_post($post_id);
    $post_meta = get_post_meta($post_id);
    $scored_data = get_post_meta($post_id, 'scored_entries', true);
    $categories_names = array();
?>
<div id="agf_html_table">
    <table class="table table-striped table-bordered table-hover" id="html-table">
        <thead>
            <tr>
                <?php 
         foreach($scored_data as $user_key => &$user){
            foreach($user['forms'] as $form_key => &$form){
                foreach($form['entries'] as $entry_key => &$entry){
                    foreach($entry['categories'] as $category_key => &$category){
                        !in_array($category_key, $categories_names) ? $categories_names[] = $category_key : null;
                    }
                }
            }
        }
        ?>
                <th>Email</th>
                <th>User Id</th>
                <th>Form Id</th>
                <th>Form Name</th>
                <th>Entry Id</th>
                <?php  foreach($categories_names as $category_name){
            echo "<th>".$category_name."</th>";
        } ?>
            </tr>
        </thead>
        <tbody>
            <?php
        foreach($scored_data as $user_key => &$user){
            foreach($user['forms'] as $form_key => &$form){
                foreach($form['entries'] as $entry_key => &$entry){
                    echo "<tr>";
                    echo "<td>".$user_key."</td>";
                    if(!empty($user_key)){
                        $user_id = get_user_by('email', $user_key)->ID;
                        if(!empty($user_id)){
                            echo "<td>".$user_id."</td>";
                        }else{
                            echo "<td></td>";
                        }
                    }
                    echo "<td>".$form["form_id"]."</td>";
                    // get gravity form by id
                    $form_name = GFAPI::get_form( $form["form_id"] )['title'];
                    echo "<td>".$form_name."</td>";
                    echo "<td>".$entry["entry_id"]."</td>";
                    foreach($categories_names as $category_name){
                        if(isset($entry['categories'][$category_name])){
                            echo "<td>".$entry['categories'][$category_name]."</td>";
                        }else{
                            echo "<td></td>";
                        }
                    }
                    echo "</tr>";
                }
            }
        }
    echo '</tbody>';
    echo '</table>';
    return ob_get_clean();
    }