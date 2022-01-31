<?php
function agf_short_code_pdf_print($atts){
    if($_REQUEST['pdf_print'] != 'true'){  
        Agf_Helper_Class::console_log('pdf_print not true');
        $post_id = $atts['id'];
        $post = get_post($post_id);
        $post_meta = get_post_meta($post_id);
        $scored_data = get_post_meta($post_id, 'scored_entries', true);
        // $user_id = get_current_user_id();
        $categories_names = array();
        $current_logged_user_id = get_current_user_id();
        $current_logged_user_data = get_user_by('id', $current_logged_user_id);
        $current_logged_user_email = $current_logged_user_data->data->user_email;

        // Get all forms that are in scored data
        $category_names = Agf_Helper_Class::get_category_names($scored_data);
        // returns array of all selected forms ids
        $all_form_ids = Agf_Helper_Class::get_current_post_selected_forms();
        // get gravity form form
        $forms_list = Agf_Helper_Class::get_form_questions($all_form_ids);
      
        // foreach questions put into html list
        $html_question_list = '<select name="selected_question[]">';
        foreach($forms_list as $form_questions){
            foreach($form_questions as $question){
                $html_question_list .= '<option>'.$question['label'].'</option>';
            }
        }
        $html_question_list .= '</select>';
        
        ob_start();
        echo '<div class="agf_pdf_print">';
        // Pop up box for selecting questions before printing
        echo '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#print_pdf_modal">Print PDF</button>
        <div class="modal fade" id="print_pdf_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form id="agf_print_pdf_form" target="_blank" action="'.get_permalink().'?pdf_print=true"
                    method="post">
                  <div class="form-group">
                    <label for="recipient-name" class="col-form-label">Client Name</label>
                    <input type="text" class="form-control" id="recipient-name" value="here is name">
                  </div>';
                  echo $html_question_list;
                  echo '<div class="form-group">
                    <label for="message-text" class="col-form-label">Message:</label>
                    <textarea name="testing-text" class="form-control" id="message-text" placeholder="Put Quote Here"></textarea>
                  </div>
                  <button type="submit">Print submit PDF</button>
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

    
    if($_REQUEST['pdf_print'] == 'true'){
        ob_clean();
        Agf_Helper_Class::console_log("pdf print true");
        $post_id = $atts['id'];
        $post_meta = get_post_meta($post_id);
        $scored_entries = maybe_unserialize($post_meta['scored_entries'][0]);
        
        ob_clean();
        ob_start();
        $mpdf = new \Mpdf\Mpdf([ 
            // 'mode' => 'utf-8',
            // 'format' => [960, 300],
            'orientation' => 'P',
            'debug' => true,
            'allow_output_buffering' => true
        ]);
        $html = '<!-- <title>Capability Assessment Results</title> -->
                <style>        
                    /* example of use:
                        body{
                            background-color: #ff764a;
                        }
                    */
                    body {
                    font-family: "Open Sans", "Helvetica Neue", sans-serif, "Segoe UI", Tahoma,
                        Geneva, Verdana, sans-serif;
                    color: #242424;
                    font-size: 1em;
                    }
                    p {
                    margin: 0;
                    padding: 4px 0;
                    }
                    .result-cells {
                    color: #ffffff;
                    font-weight: 800;
                    }
                    .container {
                    width: 960px;
                    margin: 0 auto;
                    /* border: 1px solid #424242; */
                    /* box-shadow: 0 0 5px #9e9e9e; */
                    padding: 3em;
                    padding-bottom: 0;
                    }
                    .intro-para {
                    line-height: 1.6em;
                    font-weight: 400;
                    margin-bottom: 20px;
                    }
                    .results-tab {
                    background-color: #ff764a;
                    display: inline-block;
                    padding: 1em 3em;
                    margin-left: -3em;
                    border-top-right-radius: 100px;
                    border-bottom-right-radius: 100px;
                    line-height: 1.3em;
                    }
                    /* "Your Results" text */
                    h2 {
                    font-weight: bold;
                    color: #ffffff;
                    font-size: 2em;
                    margin: 0;
                    }
                    /* TABLE BEGINS HERE */
                    .table-results {
                    margin-top: 2em;
                    border: 1px solid gray;
                    }
                    .border-color {
                    border-bottom: 3px solid #ff764a;
                    }
                    table {
                    margin: 0 auto;
                    width: 100%;
                    border-collapse: collapse;
                    }
                    th {
                    padding: 1em 0;
                    font-weight: 400;
                    }
                    th,
                    td {
                    margin: 0 auto;
                    text-align: center;
                    font-size: 1.5em;
                    }

                    td:not(:first-child) {
                    color: #ffffff;
                    font-weight: 700;
                    font-size: 1.8em;
                    }
                    .col-1 {
                    padding: 0.8em 1em;
                    font-size: 1.5em;
                    text-align: left;
                    width: 30%;
                    height: 125px;
                    }

                    .gray-cell {
                    background-color: #f3f3f3;
                    border: 1px solid white;
                    }

                    /* TABLE ENDS HERE */
                    /*--------------Table Cell Color Specifics begin Here----------*/
                    .Arow {
                    background-color: #ffa600;
                    }
                    .Brow {
                    background-color: #f29242;
                    }
                    .Crow {
                    background-color: #eb7b1e;
                    }
                    .Drow {
                    background-color: #ff764a;
                    }
                    /*--------------Table Cell Color Specifics end Here----------*/

                    .logo-row {
                    width: 100%;
                    margin: 3em 0;
                    }
                    div.logo-row img {
                    width: 10%;
                    }

                    .gradient-bottom {
                    background-image: linear-gradient(to right, #f7c35d, #d25b3c);
                    padding: 0.5em 3em;
                    width: 960px;
                    margin: 0 auto;
                    }
                </style>
                <div class="container">
                <div>
                    <h1>Capability Assessment Results</h1>
                </div>
                <div>
                    <p class="intro-para">
                        The Measured Capability Assessment is designed to map your current in-house data, measurement and decisioning capabilities to your business objectives. The results below highlight how you scored in each area. The following pages detail the characteristics of brands in each category. At the end of this document, you will the find the Capability Prioritization worksheet, which can be used to set the priorities of our engagement.
                    </p>
                </div>
                <div class="results-tab">
                    <h2>Your Results</h2>
                </div>

                <div class="table-results">
                    <table>
                        <!-- Table Row 1 -->
                        <tr class="border-color">
                            <th></Br></th>
                            <th class="gray-cell">
                                <p>Contender<br>0%-39%</p>
                            </th>
                            <th class="gray-cell">
                                <p>Challenger
                                    <br>40%-64%</p>
                            </th>
                            <th class="gray-cell">
                                <p>Leader
                                    <br>65%-89%</p>
                            </th>
                            <th class="gray-cell">
                                <p>Champion
                                    <br>90%+</p>
                            </th>
                        </tr>
                        <!-- Table Row 2 -->';

                        
        $user_email = "plutotom@Live.com";
        $entry_id = $atts['entry_id'];
        $entry_to_print = "";
        $entry_user_email = "";
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
                        if ($entry['entry_id'] == $entry_id) {
                            // set the entry_to_print to the entry
                            $entry_to_print = $entry;
                            // set the entry_user_email to the user email
                            $entry_user_email = $user;
                            // get form name 
                            $form_id = $form['form_id'];
                        }
                    }
                }
            }    
        }
        
        $table_results = null;
        // append each category and score to the table
        foreach ($entry_to_print['categories'] as $category => $score) {
            $score = round($score/5 * 100, 2);
            // if the score is less than 40
            if ($score <= 40) {
                // append the table row to the table_results
                $table_results .= '<tr>
                        <td class="col-1 gray-cell">
                            <p>'.$category.'<br>'.$score.'%</p>
                        </td>
                        <td class="Arow">A1</td>
                        <td>B1</td>
                        <td>C1</td>
                        <td>D1</td>
                    </tr>';
            }
            // if the score is between 40 and 64
            else if ($score > 40 && $score <= 64) {
                // append the table row to the table_results
                $table_results .= '<tr>
                        <td class="col-1 gray-cell">
                            <p>'.$category.'<br>'.$score.'%</p>
                        </td>
                        <td>A1</td>
                        <td class="Brow">B1</td>
                        <td>C1</td>
                        <td>D1</td>
                    </tr>';
            }
            // if the score is between 64 and 89
            else if ($score > 64 && $score <= 89) {
                // append the table row to the table_results
                $table_results .= '<tr>
                        <td class="col-1 gray-cell">
                            <p>'.$category.'<br>'.$score.'%</p>
                        </td>
                        <td>A1</td>
                        <td>B1</td>
                        <td class="Crow">C1</td>
                        <td>D1</td>
                    </tr>';
            }
            // if the score is between 89 and 100
            else if ($score > 89 && $score <= 100) {
                // append the table row to the table_results
                $table_results .= '<tr>
                        <td class="col-1 gray-cell">
                            <p>'.$category.'<br>'.$score.'%</p>
                        </td>
                        <td>A1</td>
                        <td>B1</td>
                        <td>C1</td>
                        <td class="Drow">D1</td>
                    </tr>';
            }
        }
        
        $html .= $table_results;
        $html .= '</table>
            </div>
            <!-- End Table -->
            <div class="logo-row">
                <img src="https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg">
            </div>
            </div> <!-- End Container -->
        <div class="gradient-bottom"></div>';
        $mpdf->WriteHTML($html);
        

        // End Page One
        
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
      
        // Start Page Two
        $mpdf->AddPage(); //equivalents e.g. <pagebreak /> and AddPage():
        
        //includes $page_6_styles, and $page_6_body
        include_once __DIR__ . '/../templates/measured/page6_measured_template.php';

        // Agf_Helper_Class::console_log(gettype($page_6_styles));
        $mpdf->WriteHTML($page_6_styles);
        $mpdf->WriteHTML($page_6_body);
        
        $mpdf->Output();
        return ob_get_clean();
        }
    return ob_get_clean();
}