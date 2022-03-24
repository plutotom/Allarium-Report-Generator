<?php

function agf_short_code_pdf_print_v2($atts)
{
    $atts = shortcode_atts(array(
        'id' => null,
        'entry_id' => null,
        "form_id" => null,
    ), $atts);

    if ($atts["id"] == null) {
        Agf_Helper_Class::alert_message("Please provide a form id for pdf print shortcode.");
        return;
    } elseif (!current_user_can("agf_view_report")) {
        return Agf_Helper_Class::send_error_message("You do not have permission to Print report.");
    } elseif ($atts["form_id"] == null) {
        Agf_Helper_Class::alert_message("Please provide a entry id for pdf print shortcode.");
        return;
    }

    // This updates the scored data for the post. 
    // If a new form is submitted from a user this must be called first before that entry will be in the post data.
    Agf_Helper_Class::update_post_scored_data($atts['id']);

    // strip spaces from form ids
    $form_id = str_replace(" ", "", $atts["form_id"]);
    $post_id = $atts['id'];
    // Post Meta is holds all the data. From scored entries to the entries them selves.
    $post_meta = get_post_meta($post_id);
    $scored_data = get_post_meta($post_id, 'scored_entries', true);
    if (empty($scored_data)) {
        Agf_Helper_Class::alert_message("No scored data found for this form. Please set up scoring schema first.");
        return;
    }

    // display button and form to select entires if pdf_print != true. 
    // if pdf_print == true, Will print pdf.
    if ($_REQUEST['pdf_print'] != 'true') {
        $post_id = $atts['id'];
        $post_meta = get_post_meta($post_id);
        $scored_data = get_post_meta($post_id, 'scored_entries', true);

        $current_logged_user_id = get_current_user_id();
        // $current_logged_user_email = $current_logged_user_data->data->user_email;

        // list entries from forms selected
        if (!is_array($form_id)) { // makes sure $form_id is an array.
            $form_id = array($form_id);
        }
        $entry_list = Agf_Helper_Class::get_entries_for_form($form_id);

        // foreach entry_list get entry date_created and add to html select
        $html_select_entries = '';
        $searchable_dropdown = '';
        // entries_list looks like [32 => [val1: score, val2:score], 489=>[val1: score, val2:score]]
        foreach ($entry_list as $form_id => $form_entries) {
            $html_select_entries .= '<label class="select-entry-label" for=selected_entry_for_print_id:' . $form_id . '>Select entry for ' . GFAPI::get_form($form_id)['title'] . '</label>';
            $html_select_entries .= '<select required style="width: 100%" class="agf-searchable-dropdown" name="selected_entry_for_print_id:' . $form_id . '" id="selected_entry_for_print' . $form_id . '">';
            $html_select_entries_options = '';
            $html_select_entries_options .= '<option disabled selected value="">Select entry</option>';


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

                $company_name = Agf_Helper_Class::get_company_name($entry_whole["id"], $form_id);
                // put each entry date into html select
                // if company name is not null then add company name to the list
                if ($company_name != '') {
                    $html_select_entries_options .= '<option value="' . $entry_whole["id"] . '">' . $entry_whole['date_created'] . ' - ' . $user_email_1 . ' - ' . $company_name . '</option>';
                } else {
                    $html_select_entries_options .= '<option value="' . $entry_whole["id"] . '">' . $entry_whole['date_created'] . ' - ' . $user_email_1 . '</option>';
                }
            }

            $html_select_entries .= $html_select_entries_options;
            $html_select_entries .= '</select>';
        }

        ob_start();
        echo '<div class="agf_pdf_print">';
        echo '<div class="d-none" id="overlay" onclick="agf_close_menu(event)"></div>';
        // Pop up box for selecting questions before printing
        echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#print_pdf_modal">Print PDF Single Form</button>
        <div class="modal fade bd-example-modal-lg" id="print_pdf_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        $post_id = $atts['id'];
        $form_id = $atts['form_id'];
        // get gravity forms form
        $form = GFAPI::get_form($form_id);
        $post_meta = get_post_meta($post_id);
        $scored_entries = maybe_unserialize($post_meta['scored_entries'][0]);
        // Agf_Helper_Class::console_log($scored_entries);
        //! return this back
        ob_clean();
        ob_start();

        // $_POST object looks like: 
        // Array ( [selected_entry_for_print_id:$form_id] => "entry to pint id here" [company_name] => string 'users entered value' )
        foreach ($_POST as $key => $temp_entry_id) {
            // this is to sort though the $_POST object for only the selected entries
            if (strpos($key, 'selected_entry_for_print_id') !== false) {
                // get entry from gravity forms
                $entry = GFAPI::get_entry($temp_entry_id);
                $entry_id = $temp_entry_id;
            }
        }

        // get category data 
        $category_data = maybe_unserialize($post_meta['category_data'][0]);
        // This takes an entry, and sorts it into a new object that has values sorted by teh schema categories.        
        $organized_entry = Agf_Helper_Class::organize_entry_values_by_category_name($entry_id, $form_id, $category_data);

        // for each category in organized_entry only return the values that have priority in the name
        foreach ($organized_entry as $key => $value) {
            if (strpos(strtoupper($key), 'PRIORITY') !== false) {
                $prioritization_values[$key] = $value;
            } else {
                $assessment_values[$key] = $value;
            }
        }

        // Agf_Helper_Class::console_log($assessment_values);
        // Agf_Helper_Class::console_log($prioritization_values);


        $assessment_value_average = [];
        foreach ($assessment_values as $key => $value) {
            foreach ($value as $inner_key => $inner_value) {
                $assessment_value_average[$key][] = $inner_value['entry_value'];
            }
            $assessment_value_average[$key] = array_sum($assessment_value_average[$key]) / count($assessment_value_average[$key]);
        }

        $prioritization_values_average = [];
        foreach ($prioritization_values as $key => $value) {
            foreach ($value as $inner_key => $inner_value) {
                $prioritization_values_average[$key][] = $inner_value['entry_value'];
            }
            $prioritization_values_average[$key] = array_sum($prioritization_values_average[$key]) / count($prioritization_values_average[$key]);
        }



        // Agf_Helper_Class::console_log($assessment_value_average);
        // Agf_Helper_Class::console_log($prioritization_values);
        // Agf_Helper_Class::console_log($prioritization_values_average);


        // $entry_to_print_pg_1_assessment = "";
        // Get user email from obj
        // foreach ($scored_entries as $user => $data) {
        //     // loop though each entry
        //     foreach ($data['forms'] as $form) {
        //         // loop though each entry
        //         foreach ($form['entries'] as $entry) {
        //             // loop though each entry
        //             foreach ($entry['categories'] as $category => $score) {
        //                 // loop though each entry
        //                 // if entry id matches the entry id in the obj
        //                 if ($entry['entry_id'] == $page_1_entry_assessment['id']) {
        //                     // set the entry_to_print_pg_1_assessment to the entry
        //                     $entry_to_print_pg_1_assessment = $entry;
        //                     // set the entry_user_email to the user email
        //                     $entry_to_print_pg_1_assessment_user_email = $user;
        //                     // get form name 
        //                     $form_id = $form['form_id'];
        //                 }
        //             }
        //         }
        //     }
        // }


        // // Get user email from obj
        // foreach ($scored_entries as $user => $data) {
        //     // loop though each entry
        //     foreach ($data['forms'] as $form) {
        //         // loop though each entry
        //         foreach ($form['entries'] as $entry) {
        //             // loop though each entry
        //             foreach ($entry['categories'] as $category => $score) {
        //                 // loop though each entry
        //                 // if entry id matches the entry id in the obj
        //                 if ($entry['entry_id'] == $page_6_entry_prioritization['id']) {
        //                     // set the entry_to_print_pg_1_assessment to the entry
        //                     $entry_to_print_pg_6_prioritization = $entry;
        //                     // set the entry_user_email to the user email
        //                     $entry_to_print_pg_6_user_email = $user;
        //                     // get form name 
        //                     $form_id = $form['form_id'];
        //                 }
        //             }
        //         }
        //     }
        // }

        include_once __DIR__ . '/../templates/measured_v2/page_title_measured_template.php';
        include_once __DIR__ . '/../templates/measured_v2/page1_measured_template.php';
        include_once __DIR__ . '/../templates/measured_v2/page2_measured_template.php';
        include_once __DIR__ . '/../templates/measured_v2/page3_measured_template.php';
        include_once __DIR__ . '/../templates/measured_v2/page4_measured_template.php';
        include_once __DIR__ . '/../templates/measured_v2/page5_measured_template.php';
        include_once __DIR__ . '/../templates/measured_v2/page6_measured_template.php';
        include_once __DIR__ . '/../templates/measured_v2/page7_measured_template.php';


        // if (file_exists(AGFR__PLUGIN_DIR . 'includes/templates/measured_v2/fonts/inter')) {
        //     echo "<h1>Fonts are installed</h1>";
        // }
        // if (!defined('_MPDF_PATH')) define('_MPDF_PATH', AGFR__PLUGIN_DIR . 'libraries/mpdf/');

        $defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];


        $mpdf = new \Mpdf\Mpdf([
            // 'fontDir' => [
            //     __DIR__ . '/../templates/measured_v2/fonts/inter',
            // ],
            // 'fontdata' => [
            //     // 'opensans' => [
            //     //     'R' => 'OpenSans-Regular.ttf',
            //     //     'B' => 'OpenSans-Bold.ttf',
            //     //     'I' => 'OpenSans-Italic.ttf',
            //     //     'BI' => 'OpenSans-BoldItalic.ttf',
            //     // ],
            //     'inter' => [
            //         'R' => 'Inter-Regular.ttf',
            //         'B' => 'inter-Bold.ttf',
            //         'I' => 'inter-Italic.ttf',
            //         'BI' => 'inter-BoldItalic.ttf',
            //     ],
            // ],


            'fontDir' => array_merge($fontDirs, [
                __DIR__ . '/../templates/measured_v2/fonts/inter',
            ]),
            'fontdata' => $fontData + [
                'inter' => [
                    'R' => 'Inter-Regular.ttf',
                    'B' => 'Inter-Bold.ttf',
                    'I' => 'Inter-Italic.ttf',
                    'BI' => 'Inter-BoldItalic.ttf',
                ],
            ],
            'default_font' => 'inter',

            'collapseBlockMargins ' => false,
            'margin_left' => 2,
            'margin_right' => 2,
            'margin_top' => 2,
            'margin_bottom' => 2,
            'margin_header' => 0,
            'margin_footer' => 0,
            'mode' => 'utf-8',
            // 'format' => [254, 300],
            'format' => 'Letter',
            'sheet-size' => "Letter",
            'orientation' => 'P',
            'autoPageBreak' => false,
            'debug' => true,
            'allow_output_buffering' => true,
            'use_kwt' => true, // Keep with Table. This will try and make tables fit pages but it may be inconsistent.
        ]);

        // ? Add Headers all headers to pdf here
        $mpdf->WriteHTML('<html>');
        $styles_file_dir = __DIR__ . '/../templates/measured_v2/styles.css';
        $stylesheet_for_all_pages = ('<style>' . file_get_contents($styles_file_dir) . '</style>');
        $mpdf->WriteHTML($stylesheet_for_all_pages, \Mpdf\HTMLParserMode::HEADER_CSS);

        //? Add all bodies to pdf here.
        $mpdf->WriteHTML('<body>');

        // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 450mm" />'); // page title page size
        //page title
        $mpdf->WriteHTML($page_title_body);

        // page 1
        $mpdf->WriteHTML('<pagebreak />');
        $mpdf->WriteHTML($page_6_body);
        $mpdf->WriteHTML('<pagebreak />');
        // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 280mm" />'); // page 1 page size
        $mpdf->WriteHTML($page_1_body);

        // page 6
        $mpdf->WriteHTML('<pagebreak />');
        // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 345mm" />'); // page 6 page size
        // $mpdf->WriteHTML($page_6_styles, \Mpdf\HTMLParserMode::HEADER_CSS);

        // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 235mm" />'); // page 2 page size
        $mpdf->WriteHTML($page_2_body);
        $mpdf->WriteHTML('<pagebreak />');
        // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 265mm" />'); // page 3 page size
        $mpdf->WriteHTML($page_3_body);
        $mpdf->WriteHTML('<pagebreak />');
        // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 215mm" />'); // page 4 page size
        $mpdf->WriteHTML($page_4_body);
        $mpdf->WriteHTML('<pagebreak />');
        // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 290mm" />'); // page 5 page size
        $mpdf->WriteHTML($page_5_body);



        // $mpdf->WriteHTML('<pagebreak />');
        // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 370mm" />'); // page 7 page size
        // $mpdf->WriteHTML($page_7_body);


        // // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 410mm" />'); // Prioritization page table.
        // // Getting the full entry object to get its form id to get all the forms question labels.
        // $prioritization_table_print = GFAPI::get_entry($entry_id);
        // $prioritization_form = GFAPI::get_form($form_id);
        // $prioritization_res = null;



        // $prioritization_res .= "<h1>Assessment Results</h1>";
        // $prioritization_res .= "<p style='padding-top: -25px; padding-bottom: -25px;'>Here are the answers to the questions asked during the Assessment.</p>";
        // // section text
        // $prioritization_res .= "<h1><u><b>" . $prioritization_form["title"] . "</b></u></h1>";
        // $prioritization_res .= "<table class='table_res'>";
        // foreach ($prioritization_form["fields"] as $field) {
        //     // if field type is section make a new page and table 
        //     if ($field['type'] == 'section') {
        //         // add each to prioritization results 
        //         $prioritization_res .= "<tr>";
        //         $prioritization_res .= "<td style='background-color: #EDEEEE; padding-top: 5px; padding-bottom: 5px;'>";
        //         $prioritization_res .= "<p class='section_header'>" . $field['label'] . "</p>";
        //         $prioritization_res .= "</td>";
        //         $prioritization_res .= "</tr>";
        //     }

        //     if ($field['type'] == 'select' || $field['type'] == 'radio') {
        //         // The field id is the index of the entry_to_print entry value.
        //         $field_value = $prioritization_table_print[$field['id']];
        //         $field_choices = $field['choices'];
        //         if (is_array($field_choices)) {
        //             $field_choice_values = array_column($field_choices, 'value');
        //             $field_choice_labels = array_column($field_choices, 'text');
        //         }

        //         if (in_array($field_value, $field_choice_values)) {
        //             $field_value_index = array_search($field_value, $field_choice_values);

        //             $prioritization_res .= "<tr>";
        //             $prioritization_res .= "<td style='padding-top: 4px; padding-bottom: 4px;'>";
        //             $prioritization_res .= "<p class='field_label' style='font-size: .5em;'><b>" . $field['label'] . "</b></p>";
        //             $prioritization_res .= "</td>";
        //             $prioritization_res .= "</tr>";

        //             $prioritization_res .= "<tr>";
        //             $prioritization_res .= "<td style='padding-top: 4px; padding-bottom: 4px;'>";
        //             $prioritization_res .= "<p class='field_value'>" . $field_choice_labels[$field_value_index] . "</p>";
        //             $prioritization_res .= "</td>";
        //             $prioritization_res .= "</tr>";
        //         } else {
        //             echo "N/A";
        //         }
        //     }
        // }
        // $prioritization_res .= '</table>';
        // $mpdf->WriteHTML($prioritization_res);



        // Creating Assessment Results Table and adding it to PDF.
        // Getting the full entry object to get its form id to get all the forms question labels.
        $assessment_table_print = GFAPI::get_entry($entry_id);
        $form_to_print_pg_1_assessment = GFAPI::get_form($form_id);
        // Agf_Helper_Class::console_log($form_to_print_pg_1_assessment);
        $assessment_res_started = false;
        $prioritization_started = false;

        foreach ($form_to_print_pg_1_assessment["fields"] as $key => $field) {

            if ($prioritization_started == true && $field['type'] == 'section') {
                $assessment_res .= "<tr>";
                $assessment_res .= "<td style='background-color: #EDEEEE; padding-top: 5px; padding-bottom: 5px;'>";
                $assessment_res .= "<p class='section_header'>" . $field['label'] . "</p>";
                $assessment_res .= "</td>";
                $assessment_res .= "</tr>";
            }

            // if field type is section make a new page and table 
            if ($field['type'] == 'section' && $prioritization_started == false) {
                // Agf_Helper_Class::console_log($form_to_print_pg_1_assessment["fields"][$key + 1]);
                // Agf_Helper_Class::console_log($form_to_print_pg_1_assessment["fields"]);
                // Agf_Helper_Class::console_log($key);
                if ($assessment_res_started) {
                    $assessment_res .= '</table>';
                    $mpdf->WriteHTML($assessment_res);
                }

                if ($form_to_print_pg_1_assessment["fields"][$key + 1]["type"] == 'select') {
                    // this is done so the prioritization table is only added once. 
                    $prioritization_started = true;
                    // Adding page for new section.
                    // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 280mm" />');
                    $mpdf->WriteHTML('<pagebreak/>');

                    $assessment_res_started = true;
                    $assessment_res = null;
                    $assessment_res .= "<h1 >Assessment Results</h1>";
                    $assessment_res .= "<p>Here are the answers to the questions asked during the assessment.</p>";
                    // section text
                    $assessment_res .= "<h1><u>Prioritization<u></h1>";

                    // add each to assessment results 
                    $assessment_res .= "<table class='table_res'>";
                    $assessment_res .= "<tr>";
                    $assessment_res .= "<td style='background-color: #EDEEEE; padding-top: 5px; padding-bottom: 5px;'>";
                    $assessment_res .= "<p class='section_header'>" . $field['label'] . "</p>";
                    $assessment_res .= "</td>";
                    $assessment_res .= "</tr>";
                } else {
                    // Adding page for new section.
                    // $mpdf->WriteHTML('<pagebreak sheet-size="254mm 280mm" />');
                    $mpdf->WriteHTML('<pagebreak/>');

                    $assessment_res_started = true;
                    $assessment_res = null;
                    $assessment_res .= "<h1 >Assessment Results</h1>";
                    $assessment_res .= "<p>Here are the answers to the questions asked during the assessment.</p>";
                    // section text
                    $assessment_res .= "<h1><u>" . $field['label'] . "<u></h1>";

                    // add each to assessment results 
                    $assessment_res .= "<table class='table_res'>";
                    $assessment_res .= "<tr>";
                    $assessment_res .= "<td style='background-color: #EDEEEE;'>";
                    $assessment_res .= "<p class='section_header'>" . $field['label'] . "</p>";
                    $assessment_res .= "</td>";
                    $assessment_res .= "</tr>";
                }
            }

            if ($field['type'] == 'radio') {
                // if there are less then 4 field choices then render the field label and value
                if (count($field['choices']) < 4) {
                    // The field id is the index of the entry_to_print entry value.
                    $field_value = $assessment_table_print[$field['id']];
                    $field_choices = $field['choices'];
                    if (is_array($field_choices)) {
                        $field_choice_values = array_column($field_choices, 'value');
                        $field_choice_labels = array_column($field_choices, 'text');
                    }

                    if (in_array($field_value, $field_choice_values)) {
                        $field_value_index = array_search($field_value, $field_choice_values);

                        $assessment_res .= "<tr>";
                        $assessment_res .= "<td style='padding-top: 4px; padding-bottom: 4px;'>";
                        $assessment_res .= "<p class='field_label' style='font-size: .5em;'><b>" . $field['label'] . "</b></p>";
                        $assessment_res .= "</td>";
                        $assessment_res .= "</tr>";

                        $assessment_res .= "<tr>";
                        $assessment_res .= "<td style='padding-top: 4px; padding-bottom: 4px;'>";
                        $assessment_res .= "<p class='field_value'>" . $field_choice_labels[$field_value_index] . "</p>";
                        $assessment_res .= "</td>";
                        $assessment_res .= "</tr>";
                    } else {
                        echo "N/A";
                    }
                } else {
                    // if($field['choices'])
                    // The field id is the index of the entry_to_print entry value.
                    $field_value = $assessment_table_print[$field['id']];
                    $field_choices = $field['choices'];
                    if (is_array($field_choices)) {
                        $field_choice_values = array_column($field_choices, 'value');
                        $field_choice_labels = array_column($field_choices, 'text');
                    }

                    if (in_array($field_value, $field_choice_values)) {
                        $field_value_index = array_search($field_value, $field_choice_values);

                        $assessment_res .= "<tr>";
                        $assessment_res .= "<td>";
                        $assessment_res .= "<p class='field_label' style='font-size: .5em;'><b>" . $field['label'] . "</b></p>";
                        $assessment_res .= "</td>";
                        $assessment_res .= "</tr>";

                        $assessment_res .= "<tr>";
                        $assessment_res .= "<td>";
                        $assessment_res .= "<p class='field_value'>" . $field_choice_labels[$field_value_index] . "</p>";
                        $assessment_res .= "</td>";
                        $assessment_res .= "</tr>";
                    } else {
                        echo "N/A";
                    }
                }
            }

            if ($field['type'] == 'select') {
                // The field id is the index of the entry_to_print entry value.
                $field_value = $assessment_table_print[$field['id']];
                $field_choices = $field['choices'];
                if (is_array($field_choices)) {
                    $field_choice_values = array_column($field_choices, 'value');
                    $field_choice_labels = array_column($field_choices, 'text');
                }

                if (in_array($field_value, $field_choice_values)) {
                    $field_value_index = array_search($field_value, $field_choice_values);

                    $assessment_res .= "<tr>";
                    $assessment_res .= "<td style='padding-top: 4px; padding-bottom: 4px;'>";
                    $assessment_res .= "<p class='field_label' style='font-size: .5em;'><b>" . $field['label'] . "</b></p>";
                    $assessment_res .= "</td>";
                    $assessment_res .= "</tr>";

                    $assessment_res .= "<tr>";
                    $assessment_res .= "<td style='padding-top: 4px; padding-bottom: 4px;'>";
                    $assessment_res .= "<p class='field_value'>" . $field_choice_labels[$field_value_index] . "</p>";
                    $assessment_res .= "</td>";
                    $assessment_res .= "</tr>";
                } else {
                    echo "N/A";
                }
            }
        }
        $assessment_res .= '</table>';
        $mpdf->WriteHTML($assessment_res);

        $mpdf->SetTitle($_POST["company_name"] . " Report.pdf");
        $mpdf->output($_POST["company_name"] . " Report.pdf", 'I');
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
