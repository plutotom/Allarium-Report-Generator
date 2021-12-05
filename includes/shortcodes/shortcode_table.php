<?php

function get_own_entries($entries)
{
    // get all entries for current user.
    $current_user_id = get_current_user_id();
    foreach ($entries as $entry) {
        if ($entry['created_by'] == $current_user_id) {
            $selected_form_entries[] = $entry;
        }
    }
    return $selected_form_entries;
}

function sort_entries_by_not_this_role($roles = [], $entries = [])
{
    // Gets all entries that do not have the role in the roles array.
    $selected_form_entries_by_role = [];
    foreach ($entries as $entry) {
        // get user by id
        $current_loop_user_data = get_user_by('id', $entry['created_by']);
        // if current_loop_user_data->roles is in roles array
        if (!in_array($current_loop_user_data->roles[0], $roles)) {
            $selected_form_entries_by_role[] = $entry;
        }
    }
    return $selected_form_entries_by_role;
}

function score_data($entries = [])
{
    // This gets only the imputed values from the use from an array of entries.
    // This is needed because an entry also has meta data along with it.
    $arry_of_entry_values = array();
    foreach ($entries as $key1 => $entry) {
        foreach ($entry as $key2 => $value) {
            // All keys that are numeric are entry values or section headers. The rest of the keys are form meta data.
            // Gravity form section titles have a value of '', therefore they are filtered out.
            if (is_numeric($key2) && $value !== '') {
                // add only unique key values to array
                if (!in_array($key2, $arry_of_entry_values)) {
                    $arry_of_entry_values[$key1]['data'][$key2] = $value;
                }
            }
        }
        $arry_of_entry_values[$key1]['entry'] = $entry;
    }
    // get every other 4 value. This gets each section. So section 1 with each four questions
    // will be in one array. This is done so the next step each value can be gotten by index.
    // example, index[1] will always pertain to data_driven, and index 
    // [3] always marketing_scale.
    $chunked_entries = array();
    foreach ($arry_of_entry_values as $key => $value) {
        $chunked_entries[$key]['data'] = array_chunk($value['data'], 4);
        $chunked_entries[$key]['entry'] = $value['entry'];

        // This is adding each value that pertains to one question to its own array.
        // example, index[1] will always pertain to cdbi, or index[2] to ddd.
        foreach ($chunked_entries[$key]['data'] as $key2 => $chunked_section) {
            $chunked_entries[$key]['data']['cdbi_avg'][] = $chunked_section[0];
            $chunked_entries[$key]['data']['ddd_avg'][] = $chunked_section[1];
            $chunked_entries[$key]['data']['me_avg'][] = $chunked_section[2];
            $chunked_entries[$key]['data']['ms_avg'][] = $chunked_section[3];
        }
        $chunked_entries[$key]['data']['cdbi_avg'] = array_sum($chunked_entries[$key]['data']['cdbi_avg']) / count($chunked_entries[$key]['data']['cdbi_avg']);
        $chunked_entries[$key]['data']['ddd_avg'] = array_sum($chunked_entries[$key]['data']['ddd_avg']) / count($chunked_entries[$key]['data']['ddd_avg']);
        $chunked_entries[$key]['data']['me_avg'] = array_sum($chunked_entries[$key]['data']['me_avg']) / count($chunked_entries[$key]['data']['me_avg']);
        $chunked_entries[$key]['data']['ms_avg'] = array_sum($chunked_entries[$key]['data']['ms_avg']) / count($chunked_entries[$key]['data']['ms_avg']);
    }
    return $chunked_entries;
}

function get_domains_in_scored_entries($entries = [])
{
    // This gets all domains in the scored entries then returns an array of all unique domains.

    $domains = array();
    foreach ($entries as $key => $value) {
        //only add domain if it is not already in the array
        $current_loop_user_id = $value['entry']['created_by'];
        $current_loop_user_email = get_user_by('id', $current_loop_user_id)->data->user_email;
        $domain = explode("@", $current_loop_user_email)[1];
        if (!in_array($domain, $domains)) {
            $domains[] = $domain;
        }
    }
    return $domains;
}

function agf_shortcode_table_func($atts)
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

    // Post meta data.
    $graph_type = get_post_meta($post_id, 'graph_type', true);
    $selected_email_domain = get_post_meta($post_id, 'selected_email_domain', true);
    $selected_role = get_post_meta($post_id, 'selected_role', true);
    // get selected form id from post meta data
    $selected_form_id = get_post_meta($post_id, 'selected_form_id', true);

    // get selected form entries
    $selected_form_entries = GFAPI::get_entries($selected_form_id);
    // ! ################################# End Getting Meta Data #################################

    // ? Sorting Entries by Domain
    if ($selected_email_domain !== 'all-domains') {
        // If selected_email_domain is not all-domains, then get entries by domain.
        $entries_sorted_by_domain = sort_entries_by_domain([$selected_email_domain], $selected_form_entries);
    } else {
        // No filtering needed.
        $entries_sorted_by_domain = $selected_form_entries;
    }
    // console_log($entries_sorted_by_domain);
    // console_log("^ entreis sorted by domain ");

    // ? filtering entries by user role
    if ($selected_role == 'subscriber') {
        // get only current logged in user entries.
        $entries_sorted_by_role = get_own_entries($entries_sorted_by_domain);
    } elseif ($selected_role == 'all-roles') {
        // No filtering needed.
        $entries_sorted_by_role = $entries_sorted_by_domain;
    } elseif ($selected_role == 'administrator') {
        // No filtering needed.
        $entries_sorted_by_role = $entries_sorted_by_domain;
    } elseif ($selected_role != 'subscriber' && $selected_role != 'administrator') {
        // then it is a group leader, getting all entries other then admin.
        $entries_sorted_by_role = sort_entries_by_not_this_role(['administrator'], $entries_sorted_by_domain);
    } else {
        // If for some reason the selected_role is not set, then no filtering needed.
        $entries_sorted_by_role = $entries_sorted_by_domain;
    }
    // If it is admin then no need to filter.
    // Admins can see all entries.
    // console_log($entries_sorted_by_role);
    // console_log("^ entries sorted by role and domain ");

    // ? scoring data
    $scored_data = score_data($entries_sorted_by_role);
    // log scored_data
    // console_log($scored_data);
    // console_log("^ scored data ");

    // ? Creating Array of domains that are in scored entries.
    $domains_in_scored_entries = get_domains_in_scored_entries($scored_data);


    // create an array of all users in scored entries.
    $users_names = array();
    foreach ($scored_data as $key2 => $value) {
        //only add domain if it is not already in the array
        $current_loop_user_id = $value['entry']['created_by'];
        $user = get_user_by('id', $current_loop_user_id)->data->display_name;
        if (!in_array($user, $users_names)) {
            $users_names[] = $user;
        }
    }
?>
    <!-- 	Bootstrap v2.3.2 -->
    <link rel="stylesheet" media="all" href="https://s3.amazonaws.com/dynatable-docs-assets/css/bootstrap-2.3.2.min.css" />
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
    <select id='domainInput' class='domainInput'>
        <option value=""></option>
        <?php
        foreach ($domains_in_scored_entries as $domain) {
            echo "<option value='$domain'>$domain</option>";
        }
        ?>
    </select>
    <select id='userName' class='userName'>
        <option value=""></option>
        <?php
        foreach ($users_names as $names) {
            echo "<option value='$names'>$names</option>";
        }
        ?>
    </select>
    <table class="table table-striped table-bordered table-hover" id="html-table">
        <thead>
            <tr>
                <th>User ID</th>
                <th>User Email</th>
                <th>User Name</th>
                <th>CDBI</th>
                <th>DDD</th>
                <th>ME</th>
                <th>MS</th>
                <th>Created Date</th>
            </tr>
            <tr>
        </thead>
        <tbody>
        <?php
        foreach ($scored_data as $key => $value) {
            // get user email by id
            $user_email = get_userdata($value['entry']['created_by'])->data->user_email;
            // log user email
            $user_name = get_userdata($value['entry']['created_by'])->data->display_name;
            echo '<tr>  
                <td>' . $value['entry']['created_by'] . '</td> 
                <td>' . $user_email . '</td>
                <td>' . $user_name . '</td>
                <td>' . $value['data']['cdbi_avg'] . '</td>
                <td>' . $value['data']['ddd_avg'] . '</td>
                <td>' . $value['data']['me_avg'] . '</td>
                <td>' . $value['data']['ms_avg'] . '</td>
                <td>' . $value['entry']['date_created'] . '</td>
                </tr>';
        }
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';

        return ob_get_clean();
    }
