<?php
function agf_short_code_pdf_print($atts)
{
    $atts = shortcode_atts(array(
        'id' => null,
        'entry_id' => null,
        "form_ids" => null,
    ), $atts);



    if ($atts["id"] == null) {
        Agf_Helper_Class::alert_message("Please provide a form id for pdf print shortcode.");
        return;
    } elseif ($atts["form_ids"] == null) {
        Agf_Helper_Class::alert_message("Please provide a entry id for pdf print shortcode.");
        return;
    }
    // strip spaces from form ids
    $form_ids = str_replace(" ", "", $atts["form_ids"]);
    $form_ids = explode(',', $form_ids);
    // Agf_Helper_Class::console_log($form_ids);
    $post_id = $atts['id'];
    $post = get_post($post_id);
    $post_meta = get_post_meta($post_id);
    $scored_data = get_post_meta($post_id, 'scored_entries', true);
    if (empty($scored_data)) {
        Agf_Helper_Class::alert_message("No scored data found for this form. Please set up scoring schema first.");
        return;
    }

    // display button and form to select entires if pdf_print != true. 
    // if pdf_print == true, Will print pdf.
    if ($_REQUEST['pdf_print'] != 'true') {
        Agf_Helper_Class::console_log('pdf_print not true');
        $post_id = $atts['id'];
        $post_meta = get_post_meta($post_id);
        $scored_data = get_post_meta($post_id, 'scored_entries', true);
        // $user_id = get_current_user_id();
        // $categories_names = array();
        $current_logged_user_id = get_current_user_id();
        $current_logged_user_data = get_user_by('id', $current_logged_user_id);
        // $current_logged_user_email = $current_logged_user_data->data->user_email;

        // Get all forms that are in scored data
        // $category_names = Agf_Helper_Class::get_category_names($scored_data);
        // returns array of all selected forms ids
        // $all_form_ids = Agf_Helper_Class::get_current_post_selected_forms($post_id);
        // get gravity form form
        // $forms_list = Agf_Helper_Class::get_form_questions($all_form_ids);

        // list ann entries from forms selected
        $entry_list = Agf_Helper_Class::get_entries_for_form($form_ids);

        // foreach entry_list get entry date_created and add to html select
        $html_select_entries = '';
        // entries_list looks like [32 => [val1: score, val2:score], 489=>[val1: score, val2:score]]
        // Agf_Helper_Class::console_log($entry_list);
        foreach ($entry_list as $form_id => $form_entries) {
            $html_select_entries .= '<label class="select-entry-label" for=selected_entry_for_print_id:' . $form_id . '>Select entry for ' . GFAPI::get_form($form_id)['title'] . '</label>';
            $html_select_entries .= '<select required style="width: 100%" name="selected_entry_for_print_id:' . $form_id . '" id="selected_entry_for_print' . $form_id . '">';
            $html_select_entries .= '<option disabled selected value="">Select entry</option>';

            // this would be [val1: score, val2:score]
            foreach ($form_entries as $entry_key => $entry_whole) {
                // if created_by is not null then get user email by id 
                // $user_email = Agf_Helper_Class::search_for_email_address($entry);
                if ($entry_whole['created_by'] != null) {
                    $user_data = get_user_by('id', $entry_whole['created_by']);
                    $user_email_1 = $user_data->data->user_email;
                    $user_email_2 = Agf_Helper_Class::search_for_email_address($entry_whole);
                    if ($user_email_2 != null) {
                        // user email 1 is present if a wordpress user is created the form, 
                        // user email 2 is if a user entered an email address in a field on the form.
                        $user_email_1 .= ' (' . $user_email_2 . ')';
                    }
                }
                // put each entry date into html select
                $html_select_entries .= '<option value="' . $entry_whole["id"] . '">' . $entry_whole['date_created'] . ' - ' . $user_email_1 . '</option>';
            }
            $html_select_entries .= '</select>';
        }


        // $html_search_bar = '<div id="${category_uid}" style="padding: 10px;" class="d-none shadow rounded agf-menu agf-question-list-div-with-search">
        //     <input onkeyup="agf_handel_search(event)" type="text" id="${category_uid}" class="agf-question-list-search" placeholder="Search Questions.." title="Type a question">
        //     <div class="question-list-div" id="${category_uid}">
        //   ${question_list_html}
        // </div>';

        ob_start();
        echo '<div class="agf_pdf_print">';
        // Pop up box for selecting questions before printing
        echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#print_pdf_modal">Print PDF</button>
        <div class="modal fade" id="print_pdf_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Print Measured Capability Assessment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="agf_print_pdf_form" target="_blank" action="' . get_permalink() . '?pdf_print=true"
                    method="post">
                        <div class="form-group">
                        ' . $html_select_entries . '
                        <label for="company_name">Company Name</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="Enter Company Name">
                    </div>
                  <button type="submit">Print PDF</button>
                </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>';
        echo '</div>';
        return ob_get_clean();
    }

    //! PDF PRINT START
    if ($_REQUEST['pdf_print'] == 'true') {
        ob_clean();

        Agf_Helper_Class::console_log("pdf print true");
        $post_id = $atts['id'];
        $post_meta = get_post_meta($post_id);
        $scored_entries = maybe_unserialize($post_meta['scored_entries'][0]);

        ob_clean();
        ob_start();
        foreach ($_POST as $key => $entry_id) {
            // this is to sort though the $_POST object for only the selected entries
            if (strpos($key, 'selected_entry_for_print_id') !== false) {
                // get value after : from key
                $form_id = substr($key, strpos($key, ':') + 1);
                // Agf_Helper_Class::console_log($form_id);
                // Agf_Helper_Class::console_log($entry_id);
                // get gravity forms form
                $form_title = GFAPI::get_form($form_id)['title'];
                //if form_title has Assessment in it then echo it
                if (strpos(strtoupper($form_title), 'ASSESSMENT') !== false) {
                    // Agf_Helper_Class::console_log($form_title);
                    $entry = GFAPI::get_entry($entry_id);
                    // if entry form_id === form_id then echo it
                    if ($entry['form_id'] == $form_id) {
                        $page_1_entry = $entry;
                    }
                } else {
                    $page_6_entry = GFAPI::get_entry($entry_id);
                }
            }
        }


        // return ob_get_clean();

        $entry_id = $atts['entry_id'];
        $entry_to_print_pg_1 = "";
        // Get user email from obj
        foreach ($scored_entries as $user => $data) {
            // loop though each entry
            foreach ($data['forms'] as $form) {
                // loop though each entry
                foreach ($form['entries'] as $entry) {
                    // loop though each entry
                    foreach ($entry['categories'] as $category => $score) {
                        // loop though each entry
                        // if entry id matches the entry id in the obj
                        if ($entry['entry_id'] == $page_1_entry['id']) {
                            // set the entry_to_print_pg_1 to the entry
                            $entry_to_print_pg_1 = $entry;
                            // set the entry_user_email to the user email
                            $entry_to_print_pg_1_user_email = $user;
                            // get form name 
                            $form_id = $form['form_id'];
                        }
                    }
                }
            }
        }


        foreach ($scored_entries as $user => $data) {
            // loop though each entry
            foreach ($data['forms'] as $form) {
                // loop though each entry
                foreach ($form['entries'] as $entry) {
                    // loop though each entry
                    foreach ($entry['categories'] as $category => $score) {
                        // loop though each entry
                        // if entry id matches the entry id in the obj
                        if ($entry['entry_id'] == $page_6_entry['id']) {
                            // set the entry_to_print_pg_1 to the entry
                            $entry_to_print_pg_6 = $entry;
                            // set the entry_user_email to the user email
                            $entry_to_print_pg_6_user_email = $user;
                            // get form name 
                            $form_id = $form['form_id'];
                        }
                    }
                }
            }
        }


        // $mpdf->AddPage(254, 450); //equivalents e.g. <pagebreak /> and AddPage():

        //includes $page_6_styles, and $page_6_body
        include_once __DIR__ . '/../templates/measured/page_title_measured_template.php';
        include_once __DIR__ . '/../templates/measured/page1_measured_template.php';
        include_once __DIR__ . '/../templates/measured/page2_measured_template.php';
        include_once __DIR__ . '/../templates/measured/page3_measured_template.php';
        include_once __DIR__ . '/../templates/measured/page4_measured_template.php';
        include_once __DIR__ . '/../templates/measured/page5_measured_template.php';
        include_once __DIR__ . '/../templates/measured/page6_measured_template.php';
        include_once __DIR__ . '/../templates/measured/page7_measured_template.php';

        $mpdf = new \Mpdf\Mpdf([
            // 'fontDir' => [
            //     __DIR__ . '/../templates/measured/OpenSans',
            // ],
            // 'fontdata' => [
            //     'opensans' => [
            //         'R' => 'OpenSans-Regular.ttf',
            //         'B' => 'OpenSans-Bold.ttf',
            //         'I' => 'OpenSans-Italic.ttf',
            //         'BI' => 'OpenSans-BoldItalic.ttf',
            //     ],
            // ],
            // 'default_font' => 'opensans',
            'collapseBlockMargins ' => false,
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 5,
            'margin_bottom' => 2,
            'margin_header' => 0,
            'margin_footer' => 0,
            'mode' => 'utf-8',
            // 'format' => [254, 300],
            'format' => 'Letter',
            // 'sheet-size' => "Letter",
            // 'orientation' => 'P',
            'autoPageBreak' => false,
            'progressBar' => true,
            'debug' => true,
            'allow_output_buffering' => true,
            'use_kwt' => true, // Keep with Table. This will try and make tables fit pages but it looks not great.
        ]);


        // ? Add Headers all headers to pdf here
        $mpdf->WriteHTML('<html>');
        // $mpdf->WriteHTML($page_1_head);
        $styles_file_dir = __DIR__ . '/../templates/measured/styles.css';
        $stylesheet_for_all_pages = ('<style>' . file_get_contents($styles_file_dir) . '</style>');
        $mpdf->WriteHTML($stylesheet_for_all_pages, \Mpdf\HTMLParserMode::HEADER_CSS);

        //? Add all bodies to pdf here.
        $mpdf->WriteHTML('<body>');

        //page title
        // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 450mm" />'); // page title page size
        $mpdf->WriteHTML($page_title_body);

        // page 1
        // $mpdf->WriteHTML('<pagebreak />'); // page 1 page size
        $mpdf->WriteHTML('<pagebreak sheet-size="254mm 280mm" />'); // page 1 page size
        $mpdf->WriteHTML($page_1_body);

        // page 6
        // $mpdf->WriteHTML('<pagebreak />');
        $mpdf->WriteHTML('<pagebreak sheet-size="254mm 345mm" />'); // page 6 page size
        // $mpdf->WriteHTML($page_6_styles, \Mpdf\HTMLParserMode::HEADER_CSS);
        $mpdf->WriteHTML($page_6_body);

        $mpdf->WriteHTML('<pagebreak sheet-size="254mm 235mm" />'); // page 2 page size
        $mpdf->WriteHTML($page_2_body);

        $mpdf->WriteHTML('<pagebreak sheet-size="254mm 265mm" />'); // page 3 page size
        $mpdf->WriteHTML($page_3_body);

        $mpdf->WriteHTML('<pagebreak sheet-size="254mm 215mm" />'); // page 4 page size
        $mpdf->WriteHTML($page_4_body);

        $mpdf->WriteHTML('<pagebreak sheet-size="254mm 290mm" />'); // page 5 page size
        $mpdf->WriteHTML($page_5_body);

        // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 370mm" />'); // page 7 page size
        // $mpdf->WriteHTML($page_7_body);

        // ? add footers and end of html here
        $mpdf->WriteHTML('</body></html>');
        // echo $page_title_body;
        // echo '<style>' . file_get_contents($styles_file_dir) . '</style>';
        // echo $page_1_body;
        // echo $page_2_body;
        // echo $page_3_body;
        // echo $page_4_body;
        // echo $page_5_body;
        // echo $page_6_body;

        $mpdf->output();
        return ob_get_clean();
    }
    return ob_get_clean();
}




// This uses an api to create a chart. It will return an image file. That file must be 
// bse64 decoded and placed into an image tag.
 // ***********************Creating Chart**********************************
        // Creating Chart
        // $qc = new QuickChart(array(
        //     'width' => 600,
        //     'height' => 300,
        // ));

        // $qc->setConfig('{type: "bar",
        //     data: {
        //     labels: [
        //         "Contender",
        //         "Challenger",
        //         "Leader",
        //         "Champion"
        //     ],
        //     datasets: [
        //         {
        //         label: "# of Votes",
        //         data: [12, 19, 3, 5],
        //         backgroundColor: [
        //             "rgb(244,171,50)",
        //             "rgb(236,113,118)",
        //             "rgb(91,99,162)",
        //             "rgb(26,78,106)",
        //         ],
        //         borderColor: [
        //             "rgb(244,171,50)",
        //             "rgb(236,113,118)",
        //             "rgb(91,99,162)",
        //             "rgb(26,78,106)",
        //         ],
        //         borderWidth: 1,
        //         },
        //     ],
        //     },
        //     options: {
        //     scales: {
        //         y: {
        //         beginAtZero: true,
        //         },
        //     },
        // }}');
        // // getting url that will create the chart.        
        // $url_res = $qc->getUrl();
        // // url returns image file that can be inserted into html.
        // $html .= '<img src="data:image/png;base64,'.base64_encode(file_get_contents($url_res)).'">';
        // *********************************************************
