<?php
include_once "agfr-register-post-type.php"; // register post type function.


class AgfReport {
    public function __construct() {
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'load-post.php',     array( $this, 'init_reporting_metabox' ) );
	}

    public  function init() {
        $this->enqueue_meta_box_script();
        $this->console_log("Initiating AgfReport class.");
        $this->registerReportPostType();
    }
    
    public function init_reporting_metabox(){
        add_action( 'add_meta_boxes', array( $this, 'add_reporting_metabox'  ));
        // Called when user clicks publish or save page.
        add_action( 'save_post',      array( $this, 'save_reporting_metabox' ), 10, 2 );
    }

    function enqueue_meta_box_script() {
        wp_enqueue_script( 'meta_box_script', plugin_dir_url( __FILE__ ) . 'js/meta_box.js', array( 'jquery' ) );
    }

    private  function registerReportPostType(){
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

        $this->console_log($averages);
        return $averages;
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

    public function add_reporting_metabox() {
		add_meta_box(
			'reporting-graph', // ID
			__( 'Reporting Graph', 'text_domain' ), // Title
			array( $this, 'render_metabox' ), // call back function that renders html for view
			'agfReport', // the page it is to be called on. Also called screen.
			'advanced', // Context?
			'default'   // Priority
		);
	}

    public function render_metabox( $post ) {
        wp_nonce_field( basename( __FILE__ ), 'reporting_meta_box_nonce' );
        
        // getting all forms to add to select option list.
        $forms = GFAPI::get_forms();
        // getting all needed post meta data.
        $graph_type = get_post_meta($post->ID, 'graph_type', true);
        $selected_form_id = get_post_meta($post->ID, 'selected_form_id', true);
        
        // getting all entries for selected form and averaging them.
        // every time the meta box loads this will rerun to get the latest data.
        $averaged_data_set = $this->get_entry_average_score($selected_form_id);
        
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

        // ! Sub title htlm.
            echo '<p>
                <br />
                <input class="widefat" type="text" name="sub-title-input" id="sub-title-input" value="'; echo esc_attr( get_post_meta( $post->ID, 'sub_title', true ) );
                echo '" size="30" />
            </p>';

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
                            "rgba(255, 99, 132, 0.2)",
                            "rgba(54, 162, 235, 0.2)",
                            "rgba(255, 206, 86, 0.2)",
                            "rgba(75, 192, 192, 0.2)",
                            "rgba(153, 102, 255, 0.2)",
                            "rgba(255, 159, 64, 0.2)",
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(153, 102, 255, 1)",
                            "rgba(255, 159, 64, 1)",
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


        // !#################### Sub Title #####################
        /* Get the posted data and sanitize it for use as an HTML class. */
        $new_meta_value = ( isset( $_POST['sub-title-input'] ) ? sanitize_html_class( $_POST['sub-title-input'] ) : ’ );
        /* Get the meta key. */
        $meta_key = 'sub_title';
        /* Get the meta value of the custom field key. */
        $meta_value = get_post_meta( $post_id, $meta_key, true );
        /* If a new meta value was added and there was no previous value, add it. */
        if ( $new_meta_value && ’ == $meta_value )
        add_post_meta( $post_id, $meta_key, $new_meta_value, true );
        /* If the new meta value does not match the old value, update it. */
        elseif ( $new_meta_value && $new_meta_value != $meta_value )
        update_post_meta( $post_id, $meta_key, $new_meta_value );
        /* If there is no new meta value but an old value exists, delete it. */
        elseif ( ’ == $new_meta_value && $meta_value )
        delete_post_meta( $post_id, $meta_key, $meta_value );


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

        /* If there is no new meta value but an old value exists, delete it. */
        // elseif ( ’ == $new_graph_type_meta_value && $graph_type_meta_value ){
        //     delete_post_meta( $post_id, $graph_type_meta_key, $graph_type_meta_value );
        // }
        
    }

    public function console_log($output, $with_script_tags = true) {
        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
        if ($with_script_tags) {
            $js_code = '<script>' . $js_code . '</script>';
        }
        echo $js_code;
    }

}