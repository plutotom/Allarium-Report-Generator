<?php
include_once "agfr-register-post-type.php"; // register post type function.


class AgfReport {
    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
	}

    public  function init() {
        $this->console_log("Initiating AgfReport class.");
        $this->registerReportPostType();
        $this->console_log("AgfReport Short Code initiated.");        
        add_shortcode( 'agfGraph', array( $this, 'Agf_short_code_graph_func' ) );
        add_shortcode( 'agfTable', array( $this, 'Agf_short_code_table_func' ) );
        add_action( 'add_meta_boxes', array( $this, 'register_reporting_metabox'  ));
        // Called when user clicks publish or save page.
        add_action( 'save_post',      array( $this, 'save_reporting_metabox' ), 10, 2 );   
    }

    // Getting entries based on user Role.
    public function get_entries_by_user_id($form_id, $user_arr = []){
        // filter selected_form_entries by user_id
        // get gravity forms entries
        $entries = GFAPI::get_entries($form_id); 
        foreach($user_arr as $user_id){
            foreach($entries as $entry){
                if($entry['created_by'] == $user_id){
                    $selected_form_entries[] = $entry;
                }
            }
        }
        return $selected_form_entries;
    }

    public fUnction sort_entries_by_domain($domains = [], $entries = []){
        // returns only entries that have uses in the selected domains.
            foreach($entries as $entry){
                // get user by id in order to check that uses domain.
                $entry_user_data = get_user_by('id', $entry['created_by']);
                // getting only domain (ex: @gmail.com) from email.
                $current_loop_user_domain = explode("@", $entry_user_data->data->user_email)[1];
                // if current_loop_user_domain is in domain array
                if(in_array($current_loop_user_domain, $domains)){
                    $selected_form_entries_by_domain[] = $entry;
                }
            }
        return $selected_form_entries_by_domain;
    }
    
    public function sort_entries_by_role($roles = [], $entries = []){
        $selected_form_entries_by_role = [];
        foreach($entries as $entry){
            // get user by id
            $current_loop_user_data = get_user_by('id', $entry['created_by']);
            // if current_loop_user_data->roles is in roles array
            if(in_array($current_loop_user_data->roles[0], $roles)){
                $selected_form_entries_by_role[] = $entry;
            }
        }
        return $selected_form_entries_by_role;
    }

    public function score_data($entries = []){
        // This gets only the imputed values from the use from an array of entries.
            // This is needed because an entry also has meta data along with it.
            $arry_of_entry_values = array();
            foreach($entries as $key1 => $entry){
                foreach($entry as $key2 => $value){
                    // All keys that are numeric are entry values or section headers. The rest of the keys are form meta data.
                    // Gravity form section titles have a value of '', therefore they are filtered out.
                    if(is_numeric($key2) && $value !== ''){
                        // add only unique key values to array
                        if(!in_array($key2, $arry_of_entry_values)){
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
        foreach($arry_of_entry_values as $key => $value){
            $chunked_entries[$key]['data'] = array_chunk($value['data'],4);
            $chunked_entries[$key]['entry'] = $value['entry'];

            // This is adding each value that pertains to one question to its own array.
            // example, index[1] will always pertain to cdbi, or index[2] to ddd.
            foreach($chunked_entries[$key]['data'] as $key2 => $chunked_section){
                $chunked_entries[$key]['data']['cdbi_avg'][] = $chunked_section[0];
                $chunked_entries[$key]['data']['ddd_avg'][] = $chunked_section[1];
                $chunked_entries[$key]['data']['me_avg'][] = $chunked_section[2];
                $chunked_entries[$key]['data']['ms_avg'][] = $chunked_section[3];
            }
            $chunked_entries[$key]['data']['cdbi_avg'] = array_sum($chunked_entries[$key]['data']['cdbi_avg'])/count($chunked_entries[$key]['data']['cdbi_avg']);
            $chunked_entries[$key]['data']['ddd_avg'] = array_sum($chunked_entries[$key]['data']['ddd_avg'])/count($chunked_entries[$key]['data']['ddd_avg']);
            $chunked_entries[$key]['data']['me_avg'] = array_sum($chunked_entries[$key]['data']['me_avg'])/count($chunked_entries[$key]['data']['me_avg']);
            $chunked_entries[$key]['data']['ms_avg'] = array_sum($chunked_entries[$key]['data']['ms_avg'])/count($chunked_entries[$key]['data']['ms_avg']);
        }
        return $chunked_entries;
    }

    public static function Agf_short_code_table_func( $atts ) {
        // * ################################# Getting meta data and entries #################################
        $post_id = $atts['id'];
        $post = get_post($post_id);        
        $post_meta = get_post_meta($post_id);

        // Post meta data.
        $graph_type = get_post_meta( $post_id, 'graph_type', true );
        $selected_email_domain = get_post_meta( $post_id, 'selected_email_domain', true );
        $selected_role = get_post_meta( $post_id, 'selected_role', true );
        // get selected form id from post meta data
        $selected_form_id = get_post_meta( $post_id, 'selected_form_id', true );

        // get selected form entries
        $selected_form_entries = GFAPI::get_entries($selected_form_id);

        // ! ################################# End Getting Meta Data #################################

        // ? filtering entries by user role
            $entries_sorted_by_domain = self::sort_entries_by_domain([$selected_email_domain, "live.com", "gmail.com", "hotmail.com"], $selected_form_entries);
            // log entries_sorted_by_domain
            self::console_log($entries_sorted_by_domain);
            self::console_log("^ entreis sorted by domain ");
        // ? Filtering entries by user domain.
            $entries_sorted_by_role = self::sort_entries_by_role([$selected_role], $entries_sorted_by_domain);
            // log entries_sorted_by_role
            self::console_log($entries_sorted_by_role);
            self::console_log("^ entreis sorted by user role ");
            self::console_log("Selected user Role: " . $selected_role);
            self::console_log("Selected Email domain: " . $selected_email_domain);

        // ? scoring data
            $scored_data = self::score_data($entries_sorted_by_role);
            // log scored_data
            self::console_log($scored_data);
            self::console_log("^ scored data ");
       
        // ! html table for all users scores
            $html_table = '<table class="table table-striped table-bordered table-hover" id="dataTables-example">';
            $html_table .= '<thead>';
            $html_table .= '<tr>';

            $html_table .= '<th>User ID</th>';
            $html_table .= '<th>User Email</th>';
            $html_table .= '<th>User Name</th>';
            $html_table .= '<th>CDBI</th>';
            $html_table .= '<th>DDD</th>';
            $html_table .= '<th>ME</th>';
            $html_table .= '<th>MS</th>';
            $html_table .= '<th>Created Date</th>';
            $html_table .= '</tr>';
            $html_table .= '<tr>';
            
            foreach($scored_data as $key => $value){
                // get user email by id
                $user_email = get_userdata($value['entry']['created_by'])->data->user_email;
                // log user email
                $user_name = get_userdata($value['entry']['created_by'])->data->user_nicename;
                $html_table .= '<tr>  
                <td>'.$value['entry']['created_by'].'</td> 
                <td>'.$user_email.'</td>
                <td>'.$user_name.'</td>
                <td>'.$value['data']['cdbi_avg'].'</td>
                <td>'.$value['data']['ddd_avg'].'</td>
                <td>'.$value['data']['me_avg'].'</td>
                <td>'.$value['data']['ms_avg'].'</td>
                <td>'.$value['entry']['date_created'].'</td>
                </tr>';
            }

            $html_table .= '</tr>';
            $html_table .= '</thead>';
            $html_table .= '<tbody>';
        return $html_table;

        // TODO get average with applied filters. (right now we are getting all entires and averaging them)
    }

    public static function Agf_short_code_graph_func( $atts ) {
        $post_id = $atts['id'];
        $post = get_post($post_id);
        // get graph_type from post meta data
        $graph_type = get_post_meta( $post_id, 'graph_type', true );
        // get selected form id from post meta data
        $selected_form_id = get_post_meta( $post_id, 'selected_form_id', true );
        $averaged_data_set = self::get_entry_average_score($selected_form_id);

        $graph_html = '<body width="100px" height="100px">

            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

            <div height="100px" width="100px"><canvas id="myChart" height="40vh" width="80vw"></div>
            <script>
            var ctx = document.getElementById("myChart").getContext("2d");
            var myChart = new Chart(ctx, {
            type: "'.$graph_type.'",
            data: {
            labels: ["Centralized Data and BI Reporting Priority Score", "Data-Driven Decision Making Priority Score", "Marketing Experimentation Priority Score", "Marketing Scale and Growth Priority Score"],
            datasets: [
                {
                    label: "# of Votes",
                    data: ['.$averaged_data_set['average_centralized_Data'] . ",". $averaged_data_set['average_data_driven'] .",". $averaged_data_set['average_marketing_experimentation']. ",". $averaged_data_set['average_marketing_scale']. '],
                        backgroundColor: [
                            "'.$post->graph_color_one.'",
                            "'. $post->graph_color_two . '",
                            "'. $post->graph_color_three . '",
                            "'. $post->graph_color_four . '",
                        ],
                        borderColor: [
                            "'.$post->graph_border_color_one.'",
                            "'. $post->graph_border_color_two . '",
                            "'. $post->graph_border_color_three . '",
                            "'. $post->graph_border_color_four . '",
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


        
        return $graph_html;
    }

    private function registerReportPostType(){
        $this->console_log("Initiating post type agfReport");
        // function to register post type
        init_agf_report(); // this is a imported function from agfr-register-post-type.php.
    }

    public function get_entry_average_score($form_id){
        $selected_form_entries = GFAPI::get_entries($form_id);
        
        // for each array in selected_form_entires select the items 2 - 20 items in each array in selected_form_entries
        // This gets all field values for each entry.
        $selected_form_entries_last_12 = array();
        foreach($selected_form_entries as $key => $value){
                $selected_form_entries_last_12[$key] = array_slice($value,-15);
        }
        // remove all non numeric values from selected_form_entries_last_12
        // this is done because there are some non numeric values in the array that are not scores.
        // this removes them.
        // I believe the non numeric values are the section titles.
        $selected_form_entries_last_12_numeric = array();
        foreach($selected_form_entries_last_12 as $key => $value){
            $selected_form_entries_last_12_numeric[$key] = array_filter($value, 'is_numeric');
        }

        // get every other 4 value. This gets each section. So section 1 with each four questions
        // will be in one array. This is done so the next step each value can be gotten by index.
        // example, index[1] will always pertain to data_driven, and index 
        // [3] always marketing_scale.
        $selected_form_entries_last_12_numeric_every_4 = array();
        foreach($selected_form_entries_last_12_numeric as $key => $value){
            $selected_form_entries_last_12_numeric_every_4[$key] = array_chunk($value,4);
        }

        // getting the score of each variable.
        $centralized_Data = array();
        $data_driven = array();
        $marketing_experimentation = array();
        $marketing_scale = array();
        // every item in index [0] will be centralized_Data and [2] will be marketing_experimentation
        $res = array();
        foreach($selected_form_entries_last_12_numeric_every_4 as $key => $value){
            $centralized_Data[$key] = array_map(function($v){return $v[0];}, $value);
            $data_driven[$key] = array_map(function($v){return $v[1];}, $value);
            $marketing_experimentation[$key] = array_map(function($v){return $v[2];}, $value);
            $marketing_scale[$key] = array_map(function($v){return $v[3];}, $value);
        }


        // put all the arrays in one array 
        $res['centralized_Data'] = $centralized_Data;
        $res['data_driven'] = $data_driven;
        $res['marketing_experimentation'] = $marketing_experimentation;
        $res['marketing_scale'] = $marketing_scale;

        
        // average every array in $res
        // This gives the average for each entry in each category.
        $average_centralized_Data = array_map(function($v){return array_sum($v)/count($v);}, $res['centralized_Data']);
        $average_data_driven = array_map(function($v){return array_sum($v)/count($v);}, $res['data_driven']);
        $average_marketing_experimentation = array_map(function($v){return array_sum($v)/count($v);}, $res['marketing_experimentation']);
        $average_marketing_scale = array_map(function($v){return array_sum($v)/count($v);}, $res['marketing_scale']);

        // This averages each category
        $average_centralized_Data_average = array_sum($average_centralized_Data)/count($average_centralized_Data);
        $average_data_driven_average = array_sum($average_data_driven)/count($average_data_driven);
        $average_marketing_experimentation_average = array_sum($average_marketing_experimentation)/count($average_marketing_experimentation);
        $average_marketing_scale_average = array_sum($average_marketing_scale)/count($average_marketing_scale);

        // put all the averages in one array
        $averages['average_centralized_Data'] = $average_centralized_Data_average;
        $averages['average_data_driven'] = $average_data_driven_average;
        $averages['average_marketing_experimentation'] = $average_marketing_experimentation_average;
        $averages['average_marketing_scale'] = $average_marketing_scale_average;
        
        // round the averages
        $averages['average_centralized_Data'] = round($averages['average_centralized_Data'],2);
        $averages['average_data_driven'] = round($averages['average_data_driven'],2);
        $averages['average_marketing_experimentation'] = round($averages['average_marketing_experimentation'],2);
        $averages['average_marketing_scale'] = round($averages['average_marketing_scale'],2);
        return $averages;
    }

    public function get_user_by_role($roles){
        // get users by role
        foreach($roles as $role){
            $users = get_users(array('role' => $role));
            foreach($users as $user){
                $user_array[] = $user;
            }
        }
        
        $this->console_log("All Users");
        $this->console_log($user_array);
        return $user_array;
    }

    public function add_report($entry, $form) {
        // Makes sure Gravity Forms class is available.
        if ( class_exists( 'GFCommon' ) ) {
            self::console_log("Calling add_report");

            $scored_data = $entry;
            $current_user_email = wp_get_current_user()->data->user_email;
            $current_user_id = wp_get_current_user()->data->id;

            // display entry object as string in html
            $entry_string = "<pre>";
            $entry_string .= print_r($entry, true);
            $entry_string .= "</pre>";

            $my_post = array(
                'post_title'    => wp_strip_all_tags( $current_user_email ."'s Report" ),
                'post_content'  => $entry_string,
                'post_status'   => 'publish',
                'post_author'   => $current_user_id,
                'post_type'     => 'agfReport',
            
                'meta_input' => array(
                    'scored_data' => $scored_data,
                    'selected_form_id' => $form['id'],
                    'graph_type' => 'bar'
                )
            );
            // Insert the post into the database https://developer.wordpress.org/reference/functions/wp_insert_post/
            wp_insert_post( $my_post );        
        }   
    }

    public function register_reporting_metabox() {
		add_meta_box(
			'reporting-graph', // ID
			__( 'Reporting Graph', 'text_domain' ), // Title
			array( $this, 'render_metabox' ), // call back function that renders html for view
			['agfReport', 'post', 'page'], // the page it is to be called on. Also called screen.
			'advanced', // Context?
			'default'   // Priority
		);
	}

    // has to be public
    public function render_metabox( $post ) {
        wp_nonce_field( basename( __FILE__ ), 'reporting_meta_box_nonce' );

        // getting all forms to add to select option list.
        $forms = GFAPI::get_forms();
        // getting all needed post meta data.
        $graph_type = get_post_meta($post->ID, 'graph_type', true);
        $selected_form_id = get_post_meta($post->ID, 'selected_form_id', true);
        
        // get entries for selected form
        $entries = GFAPI::get_entries($selected_form_id);
        $this->console_log($entries);

        // getting all entries for selected form and averaging them.
        // every time the meta box loads this will rerun to get the latest data.
        $averaged_data_set = $this->get_entry_average_score($selected_form_id);


        // ! Graph Color Picker
            ?>
            <div class="graph-color-picker">
                <h3 for="graph-color-picker">Graph Color Picker</h3>
                        
                <br />
                <label for="graph-color-one-picker">Graph Color One Picker HEX</label>
                <input type="color" id="graph-color-one-picker" name="graph-color-one-picker" value=<?php echo $post->graph_color_one ?> />
                <input type="color" id="graph-border-color-one-picker" name="graph-border-color-one-picker" value=<?php echo $post->graph_border_color_one ?> />
                <br/>
                <label for="graph-color-two-picker">Graph Color Two Picker HEX</label>
                <input type="color" id="graph-color-two-picker" name="graph-color-two-picker" value=<?php echo $post->graph_color_two ?> />
                <input type="color" id="graph-border-color-two-picker" name="graph-border-color-two-picker" value=<?php echo $post->graph_border_color_two ?> />
                <br/>
                <label for="graph-color-three-picker">Graph Color Three Picker HEX</label>
                <input type="color" id="graph-color-three-picker" name="graph-color-three-picker" value=<?php echo $post->graph_color_three ?> />
                <input type="color" id="graph-color-border-three-picker" name="graph-border-color-three-picker" value=<?php echo $post->graph_border_color_three ?> />
                <br/>
                <label for="graph-color-four-picker">Graph Color Four Picker HEX</label>
                <input type="color" id="graph-color-four-picker" name="graph-color-four-picker" value=<?php echo $post->graph_color_four ?> />
                <input type="color" id="graph-border-color-four-picker" name="graph-border-color-four-picker" value=<?php echo $post->graph_border_color_four ?> />
            </div>

            <br/>
            <?php
        // ! Dropdown for user domain names
            // make array of each users email 
            $user_emails = array();
            $users = get_users();
            foreach($users as $user){
                // select user email after @ and 
                // Only add email if it is not already in the array in upper case
                $user_email = substr($user->data->user_email, strpos($user->data->user_email, "@")+1);
                if(!in_array(strtoupper($user_email), $user_emails)){
                    $user_emails[] = strtoupper($user_email);
                }
            }
            $this->console_log("list of user domains");
            $this->console_log($user_emails);

            echo '<select id="email-domain-select" class="email-domain-select" name="email-domain-select">';
            foreach($user_emails as $email_domain) {
                // Making the selected filtered by email_domain be the selected option.
                if($email_domain == $post->selected_email_domain){
                    echo '<option name="email-domain-select-option" selected value="'.strtolower($email_domain).'">'.strtolower($email_domain).'</option>';
                }else{
                    echo '<option name="email-domain-select-option" value="'.strtolower($email_domain) .'">'.strtolower($email_domain) .'</option>';
                }
            }
            echo '</select>';
            echo '<button type="submit" >Filter</button>';

        // ! Sort by user roles (INCOMPLETE)
            // make array of all wordpress roels
            $roles = array();
            $roles = array_keys(get_editable_roles());

            //? Makknig select for all roles.
            //? I think this may just need to take all entries and sort them by role.
                echo '<select id="role-select" class="role-select" name="role-select">';
                echo '<option name="role-select-option" value="all_users">All Users</option>';
            foreach($roles as $role){
                // Making the selected filtered by role be the selected option.
                if($role == $post->selected_role){
                    echo '<option name="role-select-option" selected value="'.$role.'">'.$role.'</option>';
                }else{
                    echo '<option name="role-select-option" value="'.$role .'">'.$role .'</option>';
                }
            }
            echo '</select>';
            echo '<button type="submit" >Filter</button>';
        // ! Gravity form dropdown list.
            echo '<select id="form-select" class="form-select" name="form-select">';
                foreach($forms as $form) {
                    // Making the selected filtered by form be the selected option.
                    if($form['id'] == $post->selected_form_id){
                        echo '<option name="option" selected value="'.$form['id'].'">'.$form['title'].'</option>';
                    }else{
                        echo '<option name="option" value="'.$form['id'].'">'.$form['title'].'</option>';
                    }
                }
            echo '</select>';
            echo '<button type="submit" >Filter</button>';


        // ! Graph type select
            $graph_type_list = array(
                'Bar' => 'bar',
                'Pie' => 'pie',
                'Doughnut' => 'doughnut',
                'PolarArea' => 'polarArea',
                'Radar' => 'radar'
            );
            echo '<select id="graph-select" class="graph-select" name="graph-select">';
            foreach($graph_type_list as $graph) {
                // get first letter in variable and capitalize it.
                $capitalized_first_letter = ucfirst(substr($graph,0,1));
                // get all values but the first letter
                $graph_type_value = substr($graph, 1);
                // Making the selected filtered by form be the selected option.
                if($graph == $graph_type){
                echo '<option name="option" selected value="'.$graph.'">'. $capitalized_first_letter . $graph_type_value . '</option>';
                }else{
                    echo '<option name="option" value="'.$graph.'">'. $capitalized_first_letter . $graph_type_value . '</option>';
                }
            }

            echo '</select>';
            echo '<button name="graph-select-submit" type="submit" >Select Graph</button>';

		// ! Meta Box Table HTML
            echo '<style>
                    table, th, td {
                    border:1px solid black;
                    }
                </style>';

            echo '<h1>Your scores</h1>';
            echo '<table style="width:100%">
                    <tr>';
                        // for each averaged_data_set as table headers
                        foreach($averaged_data_set as $key => $value){
                            echo '<th>'.$key.'</th>';
                        }
                echo'    </tr>
                <tr>';
               //for each average score echo a column
                foreach($averaged_data_set as $key => $value){
                    echo '<td>'.$value.'</td>';
                }
                echo '<td>'. $post->sub_title .'</td>';
                echo '<td>'. $post->graph_type .'</td>';
                echo '<td>'. $post->selected_form_id .'</td>';
                echo '</tr>';
            echo '</table>';



        // ! Chart HTML 
            echo '<body width="100px" height="100px">
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

                    <div height="100px" width="100px"><canvas id="myChart" height="40vh" width="80vw"></div>
                    <script>
                    var ctx = document.getElementById("myChart").getContext("2d");
                    var myChart = new Chart(ctx, {
                    type: "'.$graph_type.'",
                    data: {
                    labels: ["Centralized Data and BI Reporting Priority Score", "Data-Driven Decision Making Priority Score", "Marketing Experimentation Priority Score", "Marketing Scale and Growth Priority Score"],
                    datasets: [
                        {
                        label: "# of Votes",
                        data: ['.$averaged_data_set['average_centralized_Data'] . ",". $averaged_data_set['average_data_driven'] .",". $averaged_data_set['average_marketing_experimentation']. ",". $averaged_data_set['average_marketing_scale']. '],
                        backgroundColor: [
                            "'.$post->graph_color_one.'",
                            "'. $post->graph_color_two . '",
                            "'. $post->graph_color_three . '",
                            "'. $post->graph_color_four . '",
                        ],
                        borderColor: [
                            "'.$post->graph_border_color_one.'",
                            "'. $post->graph_border_color_two . '",
                            "'. $post->graph_border_color_three . '",
                            "'. $post->graph_border_color_four . '",
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

    
    
                public function save_reporting_metabox( $post_id, $post ) {

        /* Verify the nonce before proceeding. */
            if ( !isset( $_POST['reporting_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['reporting_meta_box_nonce'], basename( __FILE__ ) ) )
                return $post_id;

            /* Get the post type object. */
            $post_type = get_post_type_object( $post->post_type );

            /* Check if the current user has permission to edit the post. */
            if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
            return $post_id;

        // !################### Gravity Form Select Field Save ###################
            /* Get the posted data and sanitize it for use as an HTML class. */
            $new_gf_selected_form_value = ( isset( $_POST['form-select'] ) ? sanitize_html_class( $_POST['form-select'] ) : ’ );
            /* Get the meta value of the custom field key. */
            $meta_value_select = get_post_meta( $post_id, 'selected_form_id', true );
            // Updating the selected form value.
            if($meta_value_select && ’ == $new_gf_selected_form_value ){
                add_post_meta( $post_id, 'selected_form_id', $new_gf_selected_form_value, true );
            } /* If the new meta value does not match the old value, update it. */
            elseif( $new_gf_selected_form_value != $meta_value_select ){
                update_post_meta( $post_id, 'selected_form_id', $new_gf_selected_form_value );
            }


        // !################### Graph Type ###################
            /* Get the posted data and sanitize it for use as an HTML class. */
            $new_graph_type_meta_value = ( isset( $_POST['graph-select'] ) ? sanitize_html_class( $_POST['graph-select'] ) : ’ );
            /* Get the meta key. */
            $graph_type_meta_key = 'graph_type';
            /* Get the meta value of the custom field key. */
            $graph_type_meta_value = get_post_meta( $post_id, $graph_type_meta_key, true );
            /* If a new meta value was added and there was no previous value, add it. */
            if ( $graph_type_meta_value && ’ == $new_graph_type_meta_value ){
                add_post_meta( $post_id, $graph_type_meta_key, $new_graph_type_meta_value, true );
            }
            /* If the new meta value does not match the old value, update it. */
            elseif ( $new_graph_type_meta_value != $graph_type_meta_value ){
                update_post_meta( $post_id, $graph_type_meta_key, $new_graph_type_meta_value );
            }

        // !################### Selected Role ###################
            /* Get the posted data and sanitize it for use as an HTML class. */
            $new_selected_role_meta_value = ( isset( $_POST['role-select'] ) ? sanitize_html_class( $_POST['role-select'] ) : ’ );
            /* Get the meta key. */
            $selected_role_meta_key = 'selected_role';
            /* Get the meta value of the custom field key. */
            $selected_role_meta_value = get_post_meta( $post_id, $selected_role_meta_key, true );
            /* If a new meta value was added and there was no previous value, add it. */
            if ( $selected_role_meta_value && ’ == $new_selected_role_meta_value ){
                add_post_meta( $post_id, $selected_role_meta_key, $new_selected_role_meta_value, true );
            }
            /* If the new meta value does not match the old value, update it. */
            elseif ( $new_selected_role_meta_value != $selected_role_meta_value ){
                update_post_meta( $post_id, $selected_role_meta_key, $new_selected_role_meta_value );
            }

        // !################### Saving Color picker ###################
            /* Get the posted data and sanitize it for use as an Email. Email is used to allow for # hex value. */
            $new_color_one_meta_value = ( isset( $_POST['graph-color-one-picker'] ) ? filter_var( $_POST['graph-color-one-picker'], FILTER_SANITIZE_EMAIL ) : ’ );
            /* Get the meta key. */
            $color_one_meta_key = 'graph_color_one';
            /* Get the meta value of the custom field key. */
            $color_one_meta_value = get_post_meta( $post_id, $color_one_meta_key, true );
            /* If a new meta value was added and there was no previous value, add it. */
            if ( $color_one_meta_value && ’ == $new_color_one_meta_value ){
                add_post_meta( $post_id, $color_one_meta_key, $new_color_one_meta_value, true );
            }
            /* If the new meta value does not match the old value, update it. */
            elseif ( $new_color_one_meta_value != $color_one_meta_value ){
                update_post_meta( $post_id, $color_one_meta_key, $new_color_one_meta_value );
            }

            // Color Two
          $new_color_two_meta_value = ( isset( $_POST['graph-color-two-picker'] ) ? filter_var( $_POST['graph-color-two-picker'], FILTER_SANITIZE_EMAIL ) : ’ );
            $color_two_meta_key = 'graph_color_two';
            $color_two_meta_value = get_post_meta( $post_id, $color_two_meta_key, true );
            if ( $color_two_meta_value && ’ == $new_color_two_meta_value ){
                add_post_meta( $post_id, $color_two_meta_key, $new_color_two_meta_value, true );
            }
            elseif ( $new_color_two_meta_value != $color_two_meta_value ){
                update_post_meta( $post_id, $color_two_meta_key, $new_color_two_meta_value );
            }

            // Color Three
            $new_color_three_meta_value = ( isset( $_POST['graph-color-three-picker'] ) ? filter_var( $_POST['graph-color-three-picker'], FILTER_SANITIZE_EMAIL ) : ’ );
            $color_three_meta_key = 'graph_color_three';
            $color_three_meta_value = get_post_meta( $post_id, $color_three_meta_key, true );

            if ( $color_three_meta_value && ’ == $new_color_three_meta_value ){
                add_post_meta( $post_id, $color_three_meta_key, $new_color_three_meta_value, true );
            }
            elseif ( $new_color_three_meta_value != $color_three_meta_value ){
                update_post_meta( $post_id, $color_three_meta_key, $new_color_three_meta_value );
            }

            // Color Four
            $new_color_four_meta_value = ( isset( $_POST['graph-color-four-picker'] ) ? filter_var( $_POST['graph-color-four-picker'], FILTER_SANITIZE_EMAIL ) : ’ );
            $color_four_meta_key = 'graph_color_four';
            $color_four_meta_value = get_post_meta( $post_id, $color_four_meta_key, true );

            if ( $color_four_meta_value && ’ == $new_color_four_meta_value ){
                add_post_meta( $post_id, $color_four_meta_key, $new_color_four_meta_value, true );
            }
            elseif ( $new_color_four_meta_value != $color_four_meta_value ){
                update_post_meta( $post_id, $color_four_meta_key, $new_color_four_meta_value );
            }

        // !################### Saving Graph Border Color picker ###################
            /* Get the posted data and sanitize it for use as an Email. Email is used to allow for # hex value. */
            $new_color_one_meta_value = ( isset( $_POST['graph-border-color-one-picker'] ) ? filter_var( $_POST['graph-border-color-one-picker'], FILTER_SANITIZE_EMAIL ) : ’ );
            /* Get the meta key. */
            $color_one_meta_key = 'graph_border_color_one';
            /* Get the meta value of the custom field key. */
            $color_one_meta_value = get_post_meta( $post_id, $color_one_meta_key, true );
            /* If a new meta value was added and there was no previous value, add it. */
            if ( $color_one_meta_value && ’ == $new_color_one_meta_value ){
                add_post_meta( $post_id, $color_one_meta_key, $new_color_one_meta_value, true );
            }
            /* If the new meta value does not match the old value, update it. */
            elseif ( $new_color_one_meta_value != $color_one_meta_value ){
                update_post_meta( $post_id, $color_one_meta_key, $new_color_one_meta_value );
            }

            // Color Two
          $new_color_two_meta_value = ( isset( $_POST['graph-border-color-two-picker'] ) ? filter_var( $_POST['graph-border-color-two-picker'], FILTER_SANITIZE_EMAIL ) : ’ );
            $color_two_meta_key = 'graph_border_color_two';
            $color_two_meta_value = get_post_meta( $post_id, $color_two_meta_key, true );
            if ( $color_two_meta_value && ’ == $new_color_two_meta_value ){
                add_post_meta( $post_id, $color_two_meta_key, $new_color_two_meta_value, true );
            }
            elseif ( $new_color_two_meta_value != $color_two_meta_value ){
                update_post_meta( $post_id, $color_two_meta_key, $new_color_two_meta_value );
            }

            // Color Three
            $new_color_three_meta_value = ( isset( $_POST['graph-border-color-three-picker'] ) ? filter_var( $_POST['graph-border-color-three-picker'], FILTER_SANITIZE_EMAIL ) : ’ );
            $color_three_meta_key = 'graph_border_color_three';
            $color_three_meta_value = get_post_meta( $post_id, $color_three_meta_key, true );

            if ( $color_three_meta_value && ’ == $new_color_three_meta_value ){
                add_post_meta( $post_id, $color_three_meta_key, $new_color_three_meta_value, true );
            }
            elseif ( $new_color_three_meta_value != $color_three_meta_value ){
                update_post_meta( $post_id, $color_three_meta_key, $new_color_three_meta_value );
            }

            // Color Four
            $new_color_four_meta_value = ( isset( $_POST['graph-border-color-four-picker'] ) ? filter_var( $_POST['graph-border-color-four-picker'], FILTER_SANITIZE_EMAIL ) : ’ );
            $color_four_meta_key = 'graph_border_color_four';
            $color_four_meta_value = get_post_meta( $post_id, $color_four_meta_key, true );

            if ( $color_four_meta_value && ’ == $new_color_four_meta_value ){
                add_post_meta( $post_id, $color_four_meta_key, $new_color_four_meta_value, true );
            }
            elseif ( $new_color_four_meta_value != $color_four_meta_value ){
                update_post_meta( $post_id, $color_four_meta_key, $new_color_four_meta_value );
            }


        // !################### Selected User Domain ###################
            /* Get the posted data and sanitize it for use as an HTML class. */
            $selected_email_domain_meta_value = ( isset( $_POST['email-domain-select'] ) ? filter_var( $_POST['email-domain-select'], FILTER_SANITIZE_EMAIL ) : ’ );
            /* Get the meta key. */
            $selected_email_domain_meta_key = 'selected_email_domain';
            /* Get the meta value of the custom field key. */
            $graph_type_meta_value = get_post_meta( $post_id, $selected_email_domain_meta_key, true );
            /* If a new meta value was added and there was no previous value, add it. */
            if ( $graph_type_meta_value && ’ == $selected_email_domain_meta_value ){
                add_post_meta( $post_id, $selected_email_domain_meta_key, $selected_email_domain_meta_value, true );
            }
            /* If the new meta value does not match the old value, update it. */
            elseif ( $selected_email_domain_meta_value != $graph_type_meta_value ){
                update_post_meta( $post_id, $selected_email_domain_meta_key, $selected_email_domain_meta_value );
            }

        /* If there is no new meta value but an old value exists, delete it. */
        // elseif ( ’ == $new_graph_type_meta_value && $graph_type_meta_value ){
        //     delete_post_meta( $post_id, $graph_type_meta_key, $graph_type_meta_value );
        // }
        
    }

    public function console_log($output = null, $with_script_tags = true) {
        if($output != null){
            $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
            if ($with_script_tags) {
                $js_code = '<script>' . $js_code . '</script>';
            }
            echo $js_code;
        }
    }

}





