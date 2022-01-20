<?php

function agf_short_code_pdf_print($atts){
    // ob_start();
   

    
    if($_REQUEST['pdf_print'] == 'true'){
        ob_clean();
        // flush();
        // header("Content-type:application/pdf");
        // header("Content-Disposition:attachment;filename=downloaded.pdf"); 
        
        
        $post_meta = get_post_meta(243);
        $post_meta = maybe_unserialize($post_meta['scored_entries'][0]);
        ob_clean();
        ob_start();
        $obj = '{
            "plutotom@live.com": {
              "forms": [
                {
                  "entries": [
                    {
                      "categories": {
                        "Foundations": 6.82,
                        "Organization": 5.38,
                        "Systems": 2.25
                      },
                      "entry_id": "317"
                    },
                    {
                      "categories": {
                        "Foundations": 2.24,
                        "Organization": 2.13,
                        "Systems": 2.25
                      },
                      "entry_id": "316"
                    }
                  ],
                  "form_id": "8"
                },
                {
                  "entries": [
                    {
                      "categories": {
                        "Foundations": 4
                      },
                      "entry_id": "360"
                    },
                    {
                      "categories": {
                        "Foundations": 2.18
                      },
                      "entry_id": "359"
                    }
                  ],
                  "form_id": "11"
                }
              ]
            },
            "isaiah.proctor@allarium.com": {
              "forms": [
                {
                  "entries": {
                    "2": {
                      "categories": {
                        "Foundations": 2.24,
                        "Organization": 2.13,
                        "Systems": 2.25
                      },
                      "entry_id": "315"
                    },
                    "3": {
                      "categories": {
                        "Foundations": 2.24,
                        "Organization": 2.13,
                        "Systems": 2.25
                      },
                      "entry_id": "314"
                    }
                  },
                  "form_id": "8"
                },
                {
                  "entries": {
                    "2": {
                      "categories": {
                        "Foundations": 2.18
                      },
                      "entry_id": "358"
                    },
                    "3": {
                      "categories": {
                        "Foundations": 2.18
                      },
                      "entry_id": "357"
                    },
                    "4": {
                      "categories": {
                        "Foundations": 2.18
                      },
                      "entry_id": "356"
                    },
                    "5": {
                      "categories": {
                        "Foundations": 2.18
                      },
                      "entry_id": "355"
                    },
                    "6": {
                      "categories": {
                        "Foundations": 2.18
                      },
                      "entry_id": "354"
                    },
                    "7": {
                      "categories": {
                        "Foundations": 2.18
                      },
                      "entry_id": "353"
                    },
                    "8": {
                      "categories": {
                        "Foundations": 2.18
                      },
                      "entry_id": "352"
                    },
                    "9": {
                      "categories": {
                        "Foundations": 2.18
                      },
                      "entry_id": "351"
                    },
                    "10": {
                      "categories": {
                        "Foundations": 2.18
                      },
                      "entry_id": "350"
                    }
                  },
                  "form_id": "11"
                }
              ]
            }
        }';
        $obj = json_decode($obj, true);
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
        $entry_id = "317";
        $entry_to_print = "";
        $entry_user_email = "";
        // Agf_Helper_Class::console_log($post_meta);
        // Get user email from obj
        foreach ($post_meta as $user => $data) {
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
            
        // echo '<pre>';
        // print_r($html);
        // echo '</pre>';

        // flush();
        // ob_clean();


         // ob_clean();
        // header("Content-type:application/pdf");
        // header("Content-Disposition:attachment;filename=downloaded.pdf"); 
        
        $mpdf = new \Mpdf\Mpdf([ 
            // 'mode' => 'utf-8',
            // 'format' => [960, 300],
            'orientation' => 'P',
            'debug' => true,
            'allow_output_buffering' => true
        ]);
        $mpdf->WriteHTML($html);
        // $mpdf->AddPage(); //equivalents e.g. <pagebreak /> and AddPage():
        $mpdf->Output();
    
        return ob_get_clean();
        }

    if($_REQUEST['pdf_print'] != 'true'){    
        echo '<a href="'.get_permalink().'?pdf_print=true" class="button button-primary button-large" target="_blank">Print PDF</a>';
        return ob_get_clean();
    }
        
    return ob_get_clean();

}