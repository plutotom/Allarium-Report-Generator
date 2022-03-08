<?php

$page_1_body = '<div class="container">
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
                                <p>Contender<br/>0%-39%</p>
                            </th>
                            <th class="gray-cell">
                                <p>Challenger
                                    <br/>40%-64%</p>
                            </th>
                            <th class="gray-cell">
                                <p>Leader
                                    <br/>65%-89%</p>
                            </th>
                            <th class="gray-cell">
                                <p>Champion
                                    <br/>90%+</p>
                            </th>
                        </tr>
<!-- Table Row 2 -->';


$table_results = null;
// append each category and score to the table
foreach ($assessment_value_average as $category => $score) {

    // gets the percent of score.
    $score = round($score / 4 * 100, 0);
    // if the score is less than 40
    if ($score <= 40) {
        // append the table row to the table_results
        $table_results .= '<tr>
                <td class="col-1 gray-cell">
                    <p>' . $category . '<br/></p>
                </td>
                <td class="Arow">' . $score . '%</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>';
    }
    // if the score is between 40 and 64
    else if ($score > 40 && $score <= 64) {
        // append the table row to the table_results
        $table_results .= '<tr>
                <td class="col-1 gray-cell">
                    <p>' . $category . '</p>
                </td>
                <td></td>
                <td class="Brow">' . $score . '%</td>
                <td></td>
                <td></td>
            </tr>';
    }
    // if the score is between 64 and 89
    else if ($score > 64 && $score <= 89) {
        // append the table row to the table_results
        $table_results .= '<tr>
                <td class="col-1 gray-cell">
                    <p>' . $category . '</p>
                </td>
                <td></td>
                <td></td>
                <td class="Crow">' . $score . '%</td>
                <td></td>
            </tr>';
    }
    // if the score is between 89 and 100
    else if ($score > 89 && $score <= 100) {
        // append the table row to the table_results
        $table_results .= '<tr>
                <td class="col-1 gray-cell">
                    <p>' . $category . '</p>
                </td>
                <td></td>
                <td></td>
                <td></td>
                <td class="Drow">' . $score . '%</td>
            </tr>';
    }
}

$page_1_body .= $table_results;
$page_1_body .= '</table>
    </div>
    <!-- End Table -->
    </div> <!-- End Container -->

    <div id="logo-row">
        <img src="' . __DIR__ . '/measured_icon.jpg" style="width: 32mm; height: 7mm; margin: 0;" />
    </div>
   
    <div class="gradient-bottom">
    </div>
';
