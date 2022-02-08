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
        <table class=" table table-striped table-bordered table-hover" id="html-table">
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
                    <th>Company name</th>
                    <th>Date Created</th>
                    <th>Form Name</th>
                    <!-- <th>Entry Id</th> -->
                    <?php foreach ($categories_names as $category_name) {
                        echo "<th>" . $category_name . "</th>";
                    } ?>
                </tr>
            </thead>
            <tbody>
            <?php
            Agf_Helper_Class::console_log($scored_data);
            foreach ($scored_data as $user_email => &$user) {
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

                        // get company name 
                        $company_name = Agf_Helper_Class::get_company_name($entry['entry_id'], $form["form_id"]);
                        echo "<td>" . $company_name . "</td>";
                        $entry_date_created = GFAPI::get_entry($entry['entry_id'])['date_created'];
                        echo "<td>" . date('d-m-Y', strtotime($entry_date_created)) . "</td>";
                        $form_name = GFAPI::get_form($form["form_id"])['title'];
                        echo "<td>" . $form_name . "</td>";
                        // echo "<td>".$entry["entry_id"]."</td>";
                        foreach ($categories_names as $category_name) {
                            if (isset($entry['categories'][$category_name])) {
                                if (strpos(strtoupper($form_name), 'ASSESSMENT') !== false) {
                                    $score = round($entry['categories'][$category_name] / 4 * 100, 2);
                                    echo "<td>" . $score . "%</td>";
                                } else {
                                    echo "<td>" . round($entry['categories'][$category_name] / 9 * 100, 2) . "%</td>";
                                }
                            } else {
                                echo "<td></td>";
                            }
                        }
                        echo "</tr>";
                    }
                }
            }
            echo '</tbody>';
            echo '</table>';
            echo '<button type="button" onclick="tableToCSV()">Download CSV</button>';
            echo '</div>';
            return ob_get_clean();
        }
