<?php

/*
* 
*
*/
function agf_enqueue_frontend_scripts(){
    if (get_post_type() == "agfreport") {
        if(is_single()){
            wp_enqueue_script('jPDF', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js');
            wp_enqueue_script('agf_handle_pdf_print', plugin_dir_url(__FILE__) . '../js/agf_pdf_print.js', ['jquery']);            
            // enqueue styles
            // Bootstrap styles
            wp_enqueue_style('agf_bootstrap_style', "https://s3.amazonaws.com/dynatable-docs-assets/css/bootstrap-2.3.2.min.css");
            // dynatable styles
            wp_enqueue_style('agf_dynatable_style', "https://s3.amazonaws.com/dynatable-docs-assets/css/jquery.dynatable.css");
            // Dynatable Script
            wp_enqueue_script('agf_dynatable_script', "https://s3.amazonaws.com/dynatable-docs-assets/js/jquery.dynatable.js", ['jquery']);
            // Script for Dynatable Table
            wp_enqueue_script('agf_dynatable_script_custom', plugin_dir_url(__FILE__) . '../js/agf_dynatable_script.js', ['jquery']);
        }
    }
}
?>