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


    // if($_REQUEST['pdf_print'] != 'true'){    
    //     echo '<a href="'.get_permalink().'?pdf_print=true" class="button button-primary button-large" target="_blank">Print PDF</a>';
    //     // return ob_get_clean();
    // }
    
    // if($_REQUEST['pdf_print'] == 'true'){
    //     Agf_Helper_Class::console_log('pdf_print');

    //  $mpdf = new \Mpdf\Mpdf([ 
    //         // 'mode' => 'utf-8',
    //         // 'format' => [960, 300],
    //         'orientation' => 'P',
    //         'debug' => true,
    //         'allow_output_buffering' => true
    //     ]);
    //     $mpdf->WriteHTML("<h1>Hello World!</h1>");
    //     // $mpdf->AddPage(); //equivalents e.g. <pagebreak /> and AddPage():
    //     $mpdf->Output();
    
    //     return ob_get_clean();
    // }

    if($_REQUEST['pdf_print'] != 'true'){
        Agf_Helper_Class::console_log('not pdf_print');
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