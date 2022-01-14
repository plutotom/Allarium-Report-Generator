<?php
function agf_shortcode_table_v2($atts)
{
    if ($atts['id'] == '' || $atts['id'] == null) {
        // console_log("Please add a valid post ID to short code to agfTable short code");
        return null;
    }
    // * ################################# Getting meta data and entries #################################
    ob_start();
    $post_id = $atts['id'];
    $post = get_post($post_id);
    $post_meta = get_post_meta($post_id);
    $scored_data = get_post_meta($post_id, 'scored_entries', true);
    $categories_names = array();

?>
<div id="agf_html_table">
    <!-- 	Bootstrap v2.3.2 -->
    <link rel="stylesheet" media="all"
        href="https://s3.amazonaws.com/dynatable-docs-assets/css/bootstrap-2.3.2.min.css" />
    <!-- Plugin styles -->
    <link rel="stylesheet" media="all" href="https://s3.amazonaws.com/dynatable-docs-assets/css/jquery.dynatable.css" />

    <!--  jQuery v3.0.0-beta1 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-beta1/jquery.js"></script>

    <!-- JS Pluging -->
    // ! enque scripts in wordpress.
    <script type="text/javascript" src="https://s3.amazonaws.com/dynatable-docs-assets/js/jquery.dynatable.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#html-table')
            .bind('dynatable:init', function(e, dynatable) {
                dynatable.queries.functions['domainInput'] = function(record, queryValue) {
                    // get value after @ symble in recored.userEmail
                    var domain = record.userEmail.split('@')[1];
                    return domain === queryValue;
                };
                dynatable.queries.functions['userName'] = function(record, queryValue) {
                    return queryValue === record.userName;
                };
            })
            .dynatable({
                features: {
                    paginate: false,
                    recordCount: false,
                    sorting: false,
                    search: true
                },
                inputs: {
                    queries: $('#domainInput, #userName')
                },
            });
    });
    </script>
    <!-- // ! html table for all users scores -->


    <table class="table table-striped table-bordered table-hover" id="html-table">
        <thead>
            <tr>
                <?php 
         foreach($scored_data as $user_key => &$user){
            foreach($user['forms'] as $form_key => &$form){
                foreach($form['entries'] as $entry_key => &$entry){
                    foreach($entry['categories'] as $category_key => &$category){
                        // Agf_Helper_Class::console_log($category_key);
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

// Agf_Helper_Class::console_log($scored_data);
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


        // foreach ($scored_data as $key => $value) {
        //     // get user email by id
        //     $user_email = get_userdata($value['entry']['created_by'])->data->user_email;
        //     // log user email
        //     $user_name = get_userdata($value['entry']['created_by'])->data->display_name;
        //     echo '<tr>  
        //         <td>' . $value['entry']['created_by'] . '</td> 
        //         <td>' . $user_email . '</td>
        //         <td>' . $user_name . '</td>
        //         <td>' . $value['data']['cdbi_avg'] . '</td>
        //         <td>' . $value['data']['ddd_avg'] . '</td>
        //         <td>' . $value['data']['me_avg'] . '</td>
        //         <td>' . $value['data']['ms_avg'] . '</td>
        //         <td>' . $value['entry']['date_created'] . '</td>
        //         </tr>';
        // }


        echo '</tbody>';
        echo '</table>';
        
        echo '<button type="button" class="button button-primary button-large" onclick="agf_jgeneratePDF()">Print PDF Score</button>';
        
        echo '<div id="agf_invoice">
                <h1>Our Invoice</h1>
            </div>
            </div>';
        
        return ob_get_clean();
    }