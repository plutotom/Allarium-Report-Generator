<?php

/*
* 
*
*/
function agf_enqueue_frontend_scripts(){
    if (get_post_type() == "agfreport") {
        if(is_single()){
            wp_enqueue_script('jPDF', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js');
            wp_enqueue_script('html2canvas', 'http://html2canvas.hertzen.com/dist/html2canvas.min.js', ['jPDF', 'jquery']);
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
        
            $post_data = get_post_meta(get_the_id());
            // $post_data['multi_selected_forms_ids'] = maybe_unserialize($post_data["multi_selected_forms_ids"][0]);
            $scored_entries = maybe_unserialize($post_data["scored_entries"][0]);
            $post_id = get_the_id();
            // $forms = GFAPI::get_forms();
            // $entries = [];
            // foreach($forms as $form ){
            //     $form_id = $form['id'];
            //     $entries[$form['title']] = GFAPI::get_entries( $form_id );
            // }
            // $agf_nonce = wp_create_nonce('agf_category_nonce');
            // localize script, create a custom js object
            // this will enqueue the script and append the url to a javascript variable named agf_list_questions_metabox_obj
            wp_localize_script(
                'agf_handle_pdf_print',
                'agf_handle_pdf_print', // name of javascript variable that url will be append to.
                    [
                        // 'nonce'         => $agf_nonce,
                        'ajax_url'      => admin_url('admin-ajax.php'),
                        'scored_entries'     => $scored_entries,
                        'post_id'       => $post_id,
                        // 'all_forms'     => $forms,
                        // 'all_entries'   => $entries,
                    ]
            );
        }
    }
}
?>