<?php
function agf_average_score_short_code($atts, $content = null)
{
    $a = shortcode_atts(array(
        'id' => null,
    ), $atts);

    // This updates the scored data for the post. 
    // If a new form is submitted this must be called first before that entry will be in the post data.
    Agf_Helper_Class::update_post_scored_data($a['id']);

    // if user is printing pdf then do not show the content from this short code
    if ($_REQUEST['pdf_print'] == 'true') {
        return;
    }
    $post_id = $atts['id'];
    $scored_data = get_post_meta($post_id, 'scored_entries', true);
    $current_logged_user_id = get_current_user_id();
    $current_logged_user_data = get_user_by('id', $current_logged_user_id);

    $average_score = Agf_Helper_Class::get_average_scores($scored_data);

    ob_start();

    echo '<div class="agf-average-score-container">';
    echo '<h3>Graph of Average Scores</h3>';
    echo '</div>';
    echo '
    <div width="100px" height="100px">
        <div height="100px" width="100px"><canvas id="myChart" height="40vh" width="80vw"></div>
    </div>';

    // ? this seems to be an ok work around, but may cause problems sense it is a 
    //? scripted untracked by wordpress.

?>
    <script>
        var average_score = <?php echo json_encode($average_score, JSON_NUMERIC_CHECK); ?>

        window.onload = function() {
            // Take scored_entries and put each key into an array of labels
            var labels = [];
            for (var key in average_score) {
                labels.push(key);
            }

            var ctx = document.getElementById("myChart").getContext("2d");
            var myChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                        label: "Average Score",
                        data: average_score,
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
                    }, ],
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });
        }
        console.log("script loaded end js")
    </script>


<?php

    return ob_get_clean();
}
