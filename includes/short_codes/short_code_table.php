<?php
function agf_short_code_table_render($atts)
{
    // * ################################# Getting meta data and entries #################################
    ob_start();

    $post_id = $atts['id'];
    $post = get_post($post_id);
    $post_meta = get_post_meta($post_id);
    $category_data = maybe_unserialize(get_post_meta($post_id)['category_data'][0]);
    $scored_data = get_post_meta($post_id, 'scored_entries', true);
    $categories_names = array();

?>
    <style>
        @media (min-width: 1200px) {
            .agf_table {
                margin-left: -50%;
            }
        }

        @media (max-width: 1199px) {
            #agf_html_table {
                max-width: 90%;
                overflow-x: auto;
            }
        }
    </style>
    <div id="agf_html_table">
        <table style="font-size: 14px;" class="agf_table table table-striped table-bordered table-hover" id="html-table">
            <thead>
                <tr>
                    <?php
                    foreach ($scored_data as $user_key => &$user) {
                        foreach ($user['forms'] as $form_key => &$form) {
                            foreach ($form['entries'] as $entry_key => &$entry) {
                                $entry_id = $entry['entry_id'];
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
                        $full_entry = GFAPI::get_entry($entry['entry_id']);
                        $company_name = Agf_Helper_Class::get_company_name($entry['entry_id'], $form["form_id"]);
                        echo "<td>" . $company_name . "</td>";
                        $entry_date_created = GFAPI::get_entry($entry['entry_id'])['date_created'];
                        echo "<td>" . date('d-m-Y', strtotime($entry_date_created)) . "</td>";
                        $form_name = GFAPI::get_form($form["form_id"])['title'];
                        echo "<td>" . $form_name . "</td>";
                        // echo "<td>".$entry["entry_id"]."</td>";
                        foreach ($categories_names as $category_name) {
                            // log name
                            // Agf_Helper_Class::console_log($category_name);
                            if (isset($entry['categories'][$category_name])) {
                                if (strpos(strtoupper($category_name), strtoupper('Centralized Data and BI Reporting - Priority')) !== false) {

                                    $cdbi_p  = Agf_Helper_Class::get_value_by_field_label("Centralized Data and BI Reporting Priority Score", $full_entry["id"], $full_entry["form_id"]) / 3;

                                    $cdbi_p = $cdbi_p / 9 * 100;
                                    $cdbi_p = round($cdbi_p, 1);
                                    echo "<td>" . "$cdbi_p" . "%</td>";
                                }
                                if (strpos(strtoupper($category_name), strtoupper('Marketing Experimentation - Priority')) !== false) {
                                    $mes_p  = Agf_Helper_Class::get_value_by_field_label("Marketing Experimentation Priority Score", $full_entry["id"], $full_entry["form_id"]) / 3;
                                    $mes_p = $mes_p / 9 * 100;
                                    $mes_p = round($mes_p, 1);
                                    echo "<td>" . "$mes_p" . "%</td>";
                                }
                                if (strpos(strtoupper($category_name), strtoupper('Data-Driven Decision Making - Priority')) !== false) {
                                    $dd_p  = Agf_Helper_Class::get_value_by_field_label("Data-Driven Decision Making Priority Score", $full_entry["id"], $full_entry["form_id"]) / 3;
                                    $dd_p = $dd_p / 9 * 100;
                                    $dd_p = round($dd_p, 1);
                                    echo "<td>" . "$dd_p" . "%</td>";
                                }
                                if (strpos(strtoupper($category_name), strtoupper('Marketing Scale and Growth - Priority')) !== false) {
                                    $msg_p  = Agf_Helper_Class::get_value_by_field_label("Marketing Scale and Growth Priority Score", $full_entry["id"], $full_entry["form_id"]) / 3;
                                    Agf_Helper_Class::console_log($msg_p);
                                    $msg_p = $msg_p / 9 * 100;
                                    $msg_p = round($msg_p, 1);
                                    echo "<td>" . "$msg_p" . "%</td>";
                                }



                                if (strtoupper($category_name) == strtoupper('Centralized Data and BI Reporting')) {
                                    $cdbi_a  = Agf_Helper_Class::get_value_by_field_label("Centralized Data and BI Reporting Score", $full_entry["id"], $full_entry["form_id"]) / 10;

                                    $cdbi_a = $cdbi_a / 4 * 100;
                                    $cdbi_a = round($cdbi_a, 1);
                                    echo "<td>" . "$cdbi_a" . "%</td>";
                                }
                                if (strtoupper($category_name) == strtoupper('Marketing Experimentation')) {
                                    $mes_a  = Agf_Helper_Class::get_value_by_field_label("Marketing Experimentation Score", $full_entry["id"], $full_entry["form_id"]) / 10;

                                    $mes_a = $mes_a / 4 * 100;
                                    $mes_a = round($mes_a, 1);
                                    echo "<td>" . "$mes_a" . "%</td>";
                                }
                                if (strtoupper($category_name) == strtoupper('Marketing Scale and Growth')) {
                                    $msg_a  = Agf_Helper_Class::get_value_by_field_label("Marketing Scale and Growth Score", $full_entry["id"], $full_entry["form_id"]) / 8;

                                    $msg_a = $msg_a / 4 * 100;
                                    $msg_a = round($msg_a, 1);
                                    echo "<td>" . "$msg_a" . "%</td>";
                                }
                                if (strtoupper($category_name) == strtoupper('Data-Driven Decision Making')) {
                                    $dd_a  = Agf_Helper_Class::get_value_by_field_label("Data-Driven Decision Making Score", $full_entry["id"], $full_entry["form_id"]) / 9;

                                    $dd_a = $dd_a / 4 * 100;
                                    $dd_a = round($dd_a, 1);
                                    echo "<td>" . "$dd_a" . "%</td>";
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
