<?php
include(AGFR__PLUGIN_DIR . "includes/short_codes/agf_short_code_user_score.php");
include(AGFR__PLUGIN_DIR . "includes/short_codes/agf_short_code_user_scoring_current.php");
include(AGFR__PLUGIN_DIR . "includes/short_codes/short_code_table.php");


function agf_short_code_score($atts, $content = null){
    $a = shortcode_atts( array(
        'id' => null,
        'current' => 'false',
        'entry_id' => null,
    ), $atts );

    if($_REQUEST['pdf_print'] != 'true'){
        if($a["id"] === null){
            return "Error: No Schema id given";
        }elseif($a["current"] === "true"){
            return agf_short_code_score_current($a);
        }elseif($a["entry_id"] !== null){
            return agf_short_code_user_score($a);
        }else{
            return agf_short_code_table($a);
        } 
    }
}