<?php


function agf_average_score_short_code($atts, $content = null){
    $a = shortcode_atts( array(
        'id' => null,
        
    ), $atts );

    
    
    $post_id = $atts['id'];
    $post = get_post($post_id);
    $post_meta = get_post_meta($post_id);
    $scored_data = get_post_meta($post_id, 'scored_entries', true);
    // $user_id = get_current_user_id();
    $categories_names = array();
    $current_logged_user_id = get_current_user_id();
    $current_logged_user_data = get_user_by('id', $current_logged_user_id);
    $current_logged_user_email = $current_logged_user_data->data->user_email;
    

    //average all scores 
    $average_score = Agf_Helper_Class::get_average_scores($scored_data);
    Agf_Helper_Class::console_log($average_score);
    ob_start();

    

    echo '<div class="agf-average-score-container">';
    echo '<h2>H2 average scores</h2>';
    echo '</div>';

    $average_score_labels;
    foreach($average_score as $key => $object){
        // Agf_Helper_Class::console_log($key);
        $average_score_labels[] = $key;
    }

    echo '<body width="100px" height="100px">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js" integrity="sha512-Wt1bJGtlnMtGP0dqNFH1xlkLBNpEodaiQ8ZN5JLA5wpc1sUlk/O5uuOMNgvzddzkpvZ9GLyYNa8w2s7rqiTk5Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <div height="100px" width="100px"><canvas id="myChart" height="40vh" width="80vw"></div>
    <script>
    var ctx = document.getElementById("myChart").getContext("2d");
    var myChart = new Chart(ctx, {
    type: "bar",
    data: {
    labels: '. json_encode($average_score_labels) .',
    datasets: [
        {
            label: "# of Votes",
            data: '. json_encode(array_values($average_score)) .',
                backgroundColor: [
                    "rgb(244,171,50)",
                    "rgb(236,113,118)",
                    "rgb(91,99,162)",
                    "rgb(26,78,106)",
                ],
                borderColor: [
                    "rgb(244,171,50)",
                    "rgb(236,113,118)",
                    "rgb(91,99,162)",
                    "rgb(26,78,106)",
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





    return ob_get_clean();

}