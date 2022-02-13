<?php
include(AGFR__PLUGIN_DIR . "includes/short_codes/agf_short_code_user_score.php");
include(AGFR__PLUGIN_DIR . "includes/short_codes/agf_short_code_user_scoring_current.php");
include(AGFR__PLUGIN_DIR . "includes/short_codes/short_code_table.php");


function agf_short_code_score($atts, $content = null)
{
    $atts = shortcode_atts(array(
        'id' => null, // the id of the post with the scoring schema on it
        'current' => 'false', // if this is true will only show the current logged in uses scores in table
        'entry_id' => null, // If entry_id is set then will only show the score for that entry.
    ), $atts);


    if ($atts["id"]) {
        // This updates the scored data for the post. 
        // If a new form is submitted this must be called first before that entry will be in the post data.
        Agf_Helper_Class::update_post_scored_data($atts['id']);
    }

    if ($_REQUEST['pdf_print'] != 'true') {
        if ($atts["id"] === null) {
            Agf_Helper_Class::alert_message("Please provide a post id for short code table.");
            return;
        } elseif ($atts["current"] === "true") {
            return agf_short_code_score_current($atts);
        } elseif ($atts["entry_id"] !== null) {
            return agf_short_code_user_score($atts);
        } else {
            return agf_short_code_table($atts);
        }
    }
}
