<?php


function agf_get_entry_average_score($form_id)
{
    $selected_form_entries = GFAPI::get_entries($form_id);

    // for each array in selected_form_entires select the items 2 - 20 items in each array in selected_form_entries
    // This gets all field values for each entry.
    $selected_form_entries_last_12 = array();
    foreach ($selected_form_entries as $key => $value) {
        $selected_form_entries_last_12[$key] = array_slice($value, -15);
    }
    // remove all non numeric values from selected_form_entries_last_12
    // this is done because there are some non numeric values in the array that are not scores.
    // this removes them.
    // I believe the non numeric values are the section titles.
    $selected_form_entries_last_12_numeric = array();
    foreach ($selected_form_entries_last_12 as $key => $value) {
        $selected_form_entries_last_12_numeric[$key] = array_filter($value, 'is_numeric');
    }

    // get every other 4 value. This gets each section. So section 1 with each four questions
    // will be in one array. This is done so the next step each value can be gotten by index.
    // example, index[1] will always pertain to data_driven, and index 
    // [3] always marketing_scale.
    $selected_form_entries_last_12_numeric_every_4 = array();
    foreach ($selected_form_entries_last_12_numeric as $key => $value) {
        $selected_form_entries_last_12_numeric_every_4[$key] = array_chunk($value, 4);
    }

    // getting the score of each variable.
    $centralized_Data = array();
    $data_driven = array();
    $marketing_experimentation = array();
    $marketing_scale = array();
    // every item in index [0] will be centralized_Data and [2] will be marketing_experimentation
    $res = array();
    foreach ($selected_form_entries_last_12_numeric_every_4 as $key => $value) {
        $centralized_Data[$key] = array_map(function ($v) {
            return $v[0];
        }, $value);
        $data_driven[$key] = array_map(function ($v) {
            return $v[1];
        }, $value);
        $marketing_experimentation[$key] = array_map(function ($v) {
            return $v[2];
        }, $value);
        $marketing_scale[$key] = array_map(function ($v) {
            return $v[3];
        }, $value);
    }


    // put all the arrays in one array 
    $res['centralized_Data'] = $centralized_Data;
    $res['data_driven'] = $data_driven;
    $res['marketing_experimentation'] = $marketing_experimentation;
    $res['marketing_scale'] = $marketing_scale;


    // average every array in $res
    // This gives the average for each entry in each category.
    $average_centralized_Data = array_map(function ($v) {
        return array_sum($v) / count($v);
    }, $res['centralized_Data']);
    $average_data_driven = array_map(function ($v) {
        return array_sum($v) / count($v);
    }, $res['data_driven']);
    $average_marketing_experimentation = array_map(function ($v) {
        return array_sum($v) / count($v);
    }, $res['marketing_experimentation']);
    $average_marketing_scale = array_map(function ($v) {
        return array_sum($v) / count($v);
    }, $res['marketing_scale']);

    // This averages each category
    $average_centralized_Data_average = array_sum($average_centralized_Data) / count($average_centralized_Data);
    $average_data_driven_average = array_sum($average_data_driven) / count($average_data_driven);
    $average_marketing_experimentation_average = array_sum($average_marketing_experimentation) / count($average_marketing_experimentation);
    $average_marketing_scale_average = array_sum($average_marketing_scale) / count($average_marketing_scale);

    // put all the averages in one array
    $averages['average_centralized_Data'] = $average_centralized_Data_average;
    $averages['average_data_driven'] = $average_data_driven_average;
    $averages['average_marketing_experimentation'] = $average_marketing_experimentation_average;
    $averages['average_marketing_scale'] = $average_marketing_scale_average;

    // round the averages
    $averages['average_centralized_Data'] = round($averages['average_centralized_Data'], 2);
    $averages['average_data_driven'] = round($averages['average_data_driven'], 2);
    $averages['average_marketing_experimentation'] = round($averages['average_marketing_experimentation'], 2);
    $averages['average_marketing_scale'] = round($averages['average_marketing_scale'], 2);
    return $averages;
}

function agf_render_graph_table_metabox($post)
{
    wp_nonce_field(basename(__FILE__), 'reporting_meta_box_nonce');
    $post_meta = get_post_meta($post->ID);
    // getting all forms to add to select option list.
    $forms = GFAPI::get_forms();
    // getting all needed post meta data.
    $graph_type = get_post_meta($post->ID, 'graph_type', true);
    $selected_form_id = get_post_meta($post->ID, 'selected_form_id', true);
    // get selected domain
    $selected_email_domain = get_post_meta($post->ID, 'selected_email_domain', true);
    // get entries for selected form
    $entries = GFAPI::get_entries($selected_form_id);


    // getting all entries for selected form and averaging them.
    // every time the meta box loads this will rerun to get the latest data.
    $averaged_data_set = agf_get_entry_average_score($selected_form_id);


    // ! Graph Color Picker
?>
    <div class="graph-color-picker">
        <h3 for="graph-color-picker">Graph Color Picker</h3>

        <br />
        <label for="graph-color-one-picker">Graph Color One Picker HEX</label>
        <input type="color" id="graph-color-one-picker" name="graph-color-one-picker" value=<?php echo $post->graph_color_one ?> />
        <input type="color" id="graph-border-color-one-picker" name="graph-border-color-one-picker" value=<?php echo $post->graph_border_color_one ?> />
        <br />
        <label for="graph-color-two-picker">Graph Color Two Picker HEX</label>
        <input type="color" id="graph-color-two-picker" name="graph-color-two-picker" value=<?php echo $post->graph_color_two ?> />
        <input type="color" id="graph-border-color-two-picker" name="graph-border-color-two-picker" value=<?php echo $post->graph_border_color_two ?> />
        <br />
        <label for="graph-color-three-picker">Graph Color Three Picker HEX</label>
        <input type="color" id="graph-color-three-picker" name="graph-color-three-picker" value=<?php echo $post->graph_color_three ?> />
        <input type="color" id="graph-color-border-three-picker" name="graph-border-color-three-picker" value=<?php echo $post->graph_border_color_three ?> />
        <br />
        <label for="graph-color-four-picker">Graph Color Four Picker HEX</label>
        <input type="color" id="graph-color-four-picker" name="graph-color-four-picker" value=<?php echo $post->graph_color_four ?> />
        <input type="color" id="graph-border-color-four-picker" name="graph-border-color-four-picker" value=<?php echo $post->graph_border_color_four ?> />
    </div>

    <br />
<?php
    // ! Dropdown for user domain names
    // make array of each users email 
    $user_emails = array();
    $users = get_users();

    foreach ($users as $user) {
        // select user email after @ and 
        // Only add email if it is not already in the array in upper case
        $user_email = substr($user->data->user_email, strpos($user->data->user_email, "@") + 1);
        if (!in_array(strtoupper($user_email), $user_emails)) {
            $user_emails[] = strtoupper($user_email);
        }
    }
    // Adding all_DOMAINS if not in array of all user domains.
    if (!in_array("ALL-DOMAINS", $user_emails)) {
        $user_emails[] = "ALL-DOMAINS";
    }


    echo '<select id="email-domain-select" class="email-domain-select" name="email-domain-select">';
    foreach ($user_emails as $email_domain) {
        // Making the selected filtered by email_domain be the selected option.
        if ($email_domain == strtoupper($selected_email_domain)) {
            echo '<option name="email-domain-select-option" selected value="' . strtolower($email_domain) . '">' . strtolower($email_domain) . '</option>';
        } else {
            echo '<option name="email-domain-select-option" value="' . strtolower($email_domain) . '">' . strtolower($email_domain) . '</option>';
        }
    }
    echo '</select>';

    // ! Sort by user roles
    // make array of all wordpress roels
    $roles = array();
    $roles = array_keys(get_editable_roles());
    //? Making select for all roles.
    //? I think this may just need to take all entries and sort them by role.
    echo '<select id="role-select" class="role-select" name="role-select">';
    echo '<option name="role-select-option" value="all_users">All Users</option>';
    foreach ($roles as $role) {
        // Making the selected filtered by role be the selected option.
        if ($role == $post->selected_role) {
            echo '<option name="role-select-option" selected value="' . $role . '">' . $role . '</option>';
        } else {
            echo '<option name="role-select-option" value="' . $role . '">' . $role . '</option>';
        }
    }
    echo '</select>';
    // ! Gravity form dropdown list.
    echo '<select id="form-select" class="form-select" name="form-select">';
    foreach ($forms as $form) {
        // Making the selected filtered by form be the selected option.
        if ($form['id'] == $post->selected_form_id) {
            echo '<option name="option" selected value="' . $form['id'] . '">' . $form['title'] . '</option>';
        } else {
            echo '<option name="option" value="' . $form['id'] . '">' . $form['title'] . '</option>';
        }
    }
    echo '</select>';

    // ! Graph type select
    $graph_type_list = array(
        'Bar' => 'bar',
        'Pie' => 'pie',
        'Doughnut' => 'doughnut',
        'PolarArea' => 'polarArea',
        'Radar' => 'radar'
    );
    echo '<select id="graph-select" class="graph-select" name="graph-select">';
    foreach ($graph_type_list as $graph) {
        // get first letter in variable and capitalize it.
        $capitalized_first_letter = ucfirst(substr($graph, 0, 1));
        // get all values but the first letter
        $graph_type_value = substr($graph, 1);
        // Making the selected filtered by form be the selected option.
        if ($graph == $graph_type) {
            echo '<option name="option" selected value="' . $graph . '">' . $capitalized_first_letter . $graph_type_value . '</option>';
        } else {
            echo '<option name="option" value="' . $graph . '">' . $capitalized_first_letter . $graph_type_value . '</option>';
        }
    }

    echo '</select>';
    echo '<button type="submit" >Filter</button>';





    // ! Chart HTML 
    echo '<body width="100px" height="100px">
                <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

                <div height="100px" width="100px"><canvas id="myChart" height="40vh" width="80vw"></div>
                <script>
                var ctx = document.getElementById("myChart").getContext("2d");
                var myChart = new Chart(ctx, {
                type: "' . $graph_type . '",
                data: {
                labels: ["Centralized Data and BI Reporting Priority Score", "Data-Driven Decision Making Priority Score", "Marketing Experimentation Priority Score", "Marketing Scale and Growth Priority Score"],
                datasets: [
                    {
                    label: "# of Votes",
                    data: [' . $averaged_data_set['average_centralized_Data'] . "," . $averaged_data_set['average_data_driven'] . "," . $averaged_data_set['average_marketing_experimentation'] . "," . $averaged_data_set['average_marketing_scale'] . '],
                    backgroundColor: [
                        "' . $post->graph_color_one . '",
                        "' . $post->graph_color_two . '",
                        "' . $post->graph_color_three . '",
                        "' . $post->graph_color_four . '",
                    ],
                    borderColor: [
                        "' . $post->graph_border_color_one . '",
                        "' . $post->graph_border_color_two . '",
                        "' . $post->graph_border_color_three . '",
                        "' . $post->graph_border_color_four . '",
                    ],
                    borderWidth: 1,
                    },
                ],
                },
                options: {
                    
                scales: {
                    y: {
                        
                    beginAtZero: true,
                    },
                },
                },
                });
                </script>
                </body>';
}
