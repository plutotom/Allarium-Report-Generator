<?php



$page_1_styles = '<style>
    /* cyrillic-ext */
    @font-face {
    font-family: "Open Sans";
    font-style: italic;
    font-weight: 400;
    font-stretch: 100%;
    font-display: swap;
    src: url(https://fonts.gstatic.com/s/opensans/v27/memQYaGs126MiZpBA-UFUIcVXSCEkx2cmqvXlWq8tWZ0Pw86hd0Rk8ZkWV0exoMUdjFXmSU_.woff) format("woff");
    unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
    }
    /* cyrillic */
    @font-face {
    font-family: "Open Sans";
    font-style: italic;
    font-weight: 400;
    font-stretch: 100%;
    font-display: swap;
    src: url(https://fonts.gstatic.com/s/opensans/v27/memQYaGs126MiZpBA-UFUIcVXSCEkx2cmqvXlWq8tWZ0Pw86hd0Rk8ZkWVQexoMUdjFXmSU_.woff) format("woff");
    unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
    }
    /* greek-ext */
    @font-face {
    font-family: "Open Sans";
    font-style: italic;
    font-weight: 400;
    font-stretch: 100%;
    font-display: swap;
    src: url(https://fonts.gstatic.com/s/opensans/v27/memQYaGs126MiZpBA-UFUIcVXSCEkx2cmqvXlWq8tWZ0Pw86hd0Rk8ZkWVwexoMUdjFXmSU_.woff) format("woff");
    unicode-range: U+1F00-1FFF;
    }
    /* greek */
    @font-face {
    font-family: "Open Sans";
    font-style: italic;
    font-weight: 400;
    font-stretch: 100%;
    font-display: swap;
    src: url(https://fonts.gstatic.com/s/opensans/v27/memQYaGs126MiZpBA-UFUIcVXSCEkx2cmqvXlWq8tWZ0Pw86hd0Rk8ZkWVMexoMUdjFXmSU_.woff) format("woff");
    unicode-range: U+0370-03FF;
    }
    /* hebrew */
    @font-face {
    font-family: "Open Sans";
    font-style: italic;
    font-weight: 400;
    font-stretch: 100%;
    font-display: swap;
    src: url(https://fonts.gstatic.com/s/opensans/v27/memQYaGs126MiZpBA-UFUIcVXSCEkx2cmqvXlWq8tWZ0Pw86hd0Rk8ZkWVIexoMUdjFXmSU_.woff) format("woff");
    unicode-range: U+0590-05FF, U+20AA, U+25CC, U+FB1D-FB4F;
    }
    /* vietnamese */
    @font-face {
    font-family: "Open Sans";
    font-style: italic;
    font-weight: 400;
    font-stretch: 100%;
    font-display: swap;
    src: url(https://fonts.gstatic.com/s/opensans/v27/memQYaGs126MiZpBA-UFUIcVXSCEkx2cmqvXlWq8tWZ0Pw86hd0Rk8ZkWV8exoMUdjFXmSU_.woff) format("woff");
    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
    }
    /* latin-ext */
    @font-face {
    font-family: "Open Sans";
    font-style: italic;
    font-weight: 400;
    font-stretch: 100%;
    font-display: swap;
    src: url(https://fonts.gstatic.com/s/opensans/v27/memQYaGs126MiZpBA-UFUIcVXSCEkx2cmqvXlWq8tWZ0Pw86hd0Rk8ZkWV4exoMUdjFXmSU_.woff) format("woff");
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
    }
    /* latin */
    @font-face {
    font-family: "Open Sans";
    font-style: italic;
    font-weight: 400;
    font-stretch: 100%;
    font-display: swap;
    src: url(https://fonts.gstatic.com/s/opensans/v27/memQYaGs126MiZpBA-UFUIcVXSCEkx2cmqvXlWq8tWZ0Pw86hd0Rk8ZkWVAexoMUdjFXmQ.woff) format("woff");
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
    }
    </style>

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
    color: white;
    }
    .Brow {
    background-color: #f29242;
    color: white;
    }
    .Crow {
    background-color: #eb7b1e;
    color: white;
    }
    .Drow {
    background-color: #ff764a;
    color: white;
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
</style>';


$page_1_head = '<!-- <title>Capability Assessment Results</title> -->
    <head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital@1&display=swap" rel="stylesheet">
        ' . $page_1_styles . '
</head>';



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
foreach ($entry_to_print_pg_1['categories'] as $category => $score) {
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
