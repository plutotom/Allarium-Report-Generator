<?php

/*
* 
*
*/
function agf_enqueue_frontend_scripts()
{
    // if (get_post_type() == "agfreport") {
    //     if(is_single()){
    $post_data = get_post_meta(get_the_id());
    // $post_data['multi_selected_forms_ids'] = maybe_unserialize($post_data["multi_selected_forms_ids"][0]);
    $scored_entries = maybe_unserialize($post_data["scored_entries"][0]);
    $post_id = get_the_id();

    // wp_enqueue_script('jsPDF', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js');
    // wp_enqueue_script('html2canvas', 'http://html2canvas.hertzen.com/dist/html2canvas.min.js', ['jPDF', 'jquery']);
    wp_enqueue_script('agf_handle_pdf_print', plugin_dir_url(__FILE__) . '../js/agf_pdf_print.js', ['jquery']);
    // enqueue styles
    // Bootstrap Script
    wp_enqueue_script('agf_bootstrap_v4_script', "https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js");
    // Bootstrap styles
    wp_enqueue_style('agf_bootstrap_v4_style', "https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css");
    // wp_enqueue_style('agf_bootstrap_style', "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css");
    // dynatable styles
    wp_enqueue_style('agf_dynatable_style', "https://s3.amazonaws.com/dynatable-docs-assets/css/jquery.dynatable.css");
    // Dynatable Script
    wp_enqueue_script('agf_dynatable_script', "https://s3.amazonaws.com/dynatable-docs-assets/js/jquery.dynatable.js", ['jquery']);
    // Script for Dynatable Table
    wp_enqueue_script('agf_dynatable_script_custom', plugin_dir_url(__FILE__) . '../js/agf_dynatable_script.js', ['jquery']);
    // Script for charts.js 
    wp_enqueue_script("Chart.min.js", "https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js", ['jquery'], 1);
    // wp_enqueue_script('agf_charts_average', plugin_dir_url(__FILE__) . '../js/agf_charts_average.js', ['jquery'], 10, false);
    wp_enqueue_script('agf_table_to_csv', plugin_dir_url(__FILE__) . '../js/agf_table_to_csv.js', ['jquery'], 10, false);
    // wp_enqueue_script('agf_searchable_dropdown', plugin_dir_url(__FILE__) . '../js/agf_searchable_dropdown.js', 10, false);

    wp_enqueue_script('agf_select2_script', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', ['jquery'], 10, false);
    wp_enqueue_style('agf_select2_style', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
    wp_enqueue_script('agf_select2_script_custom', plugin_dir_url(__FILE__) . '../js/agf_select2_script_custom.js', ['jquery', 'agf_select2_script'], 10, false);

    $average_score = Agf_Helper_Class::get_average_scores($scored_entries);
    // wp_localize_script(
    //     'agf_charts_average',
    //     'agf_charts_average', // name of javascript variable that url will be append to.
    //     [
    //         'ajax_url'         => admin_url('admin-ajax.php'),
    //         'scored_entries'   => $scored_entries,
    //         'average_score'    => $average_score,
    //         'post_id'          => $post_id,
    //     ]
    // );
    // localize script, create a custom js object
    // this will enqueue the script and append the url to a javascript variable named agf_list_questions_metabox_obj
    wp_localize_script(
        'agf_handle_pdf_print',
        'agf_handle_pdf_print', // name of javascript variable that url will be append to.
        [
            // 'nonce'         => $agf_nonce,
            'ajax_url'         => admin_url('admin-ajax.php'),
            'scored_entries'   => $scored_entries,
            'post_id'          => $post_id,
            // 'all_forms'     => $forms,
            // 'all_entries'   => $entries,
        ]
    );
}
//     }
// }
