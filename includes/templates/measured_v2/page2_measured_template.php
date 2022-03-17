<?php


// foreach ($entry_to_print_pg_1_assessment['categories'] as $category => $score) {
//     $score = round($score / 4 * 100, 2);
//     // return only the highest score
//     $highest_score = null;
//     if ($score > $highest_score) {
//         $highest_score = $score;
//         $highest_category = $category;
//     }
// }
// Centralized Data and BI Reporting
$bi_score = $assessment_value_average['Centralized Data and BI Reporting'];
$bi_score = round($bi_score / 4 * 100, 2);

$Contender = null;
$Challenger = null;
$Leader = null;
$Champion = null;

// Agf_Helper_Class::console_log($highest_category);
// $highest_category
if ($bi_score >= 90) {
    $Champion = "isSelected";
} elseif ($bi_score >= 65) {
    $Leader = "isSelected";
} elseif ($bi_score >= 40) {
    $Challenger = "isSelected";
} else {
    $Contender = "isSelected";
}


$page_2_body = '
    <div class="container">
        <div class="row">
            <div class="page2title">
            <h4>Centralized Data and <BR>BI Reporting </h4>
            </div>
            <div class="results-tab2">
                <h2>Capability Overview </h2>
            </div>
        </div>

        <div class="row">
            <div class="intro-para2">
                <p>Centralized Data and BI Reporting is the system of storing and managing all business intelligence, or data, in one central location or department for governance and security reasons. This model ensures data accuracy, veracity, and economy of scale.
                </p>
            </div>
            <div class="discussion">
                <p>Discussion Questions</br></p>
                <ul>
                    <li><span>Who owns this in my org?</span></li>
                    <li><span>Who utilizes this in my org?</span></li>
                </ul>
            </div>
            <div style="clear: both;"></div>
        </div>


        <div class="row">
        
        <table class="overview-table">
                <tr>
                <th class="overview-header"></th>
                <th class="overview-header ' . $Contender . '">Contender</th>
                <th class="overview-header ' . $Challenger . '">Challenger</th>
                <th class="overview-header ' . $Leader . '">Leader</th>
                <th class="overview-header ' . $Champion . '">Champion</th>

                /* Row 1 */
                    <tr>
                        <td>Data Centralization</td>
                        <td class="' . $Contender . '">Has no centralized data or automation.</td>
                        <td class="' . $Challenger . '">Has no centralized data or automation but uses resources to streamline group data access.</td>
                        <td class="' . $Leader . '">Has implemented a centralized data warehouse but key gaps may exist and/or data QA is manual and subject to frequent breakages.</td>
                        <td class="' . $Champion . '">Has implemented a centralized data lake across all key data sets with daily updates and quality control.</td>
                    </tr>

                /* Row 2 */
                    <tr>
                        <td>Reporting Standardization</td>
                        <td class="' . $Contender . '" >Numerous people check numerous vendor dashboards, e.g. Google Ads, Shopify, AdsManager, etc.</td>
                        <td class="' . $Challenger . '">Has started to standardize key high-level monthly reports with data aggregated across platforms.</td>
                        <td class="' . $Leader . '">Standardized suite of reports, possibly using a BI tool. Has a siloed approach where different parts of the organization may use different approaches.</td>
                        <td class="' . $Champion . '">Has standardized reporting via a centralized BI tool aligned across the organization.</td>
                    </tr>
                
                /* Row 3 */
                    <tr>
                        <td>Reporting Automation</td>
                        <td class="' . $Contender . '" >Most reporting ad hoc or done across key vendor platforms.</td>
                        <td class="' . $Challenger . '">Report format is automated but still created manually in Excel or Ppt.</td>
                        <td class="' . $Leader . '">Most reporting is standardized in Excel and/or Ppt but some level of data automation has been achieved.</td>
                        <td class="' . $Champion . '">Reporting automated through a BI tool built on top of a comprehensive marketing data lake.</td>
                    
                    </tr>
                
                    /* Row 4 */
                    <tr>
                        <td>Reporting Frequency</td>
                        <td class="' . $Contender . '">Ad hoc</td>
                        <td class="' . $Challenger . '">Reporting cadence is bi-weekly to monthly.</td>
                        <td class="' . $Leader . '">Reporting cadence is weekly.</td>
                        <td class="' . $Champion . '">Has automated reports available daily.</td>
                    
                    </tr>


            </table>
        </div> 
        
    </div> <!-- End Container -->

    <div id="logo-row">
        <img src="' . __DIR__ . '/measured_icon.jpg" style="width: 32mm; height: 7mm; margin: 0;" />
    </div>
    <div class="overview-bottom" style="margin-top: 180px;">
        <div class="col">
            <!-- <div class="orangecir"></div> -->                
            <div id="plus_minus_icon_parent">
                <img id="plus_minus_icons" src="' . __DIR__ . '/plus_svg.svg" />
            </div>
            <p>Teams that have mastered Centralized Data and  BI Reporting benefit from consistent quality control, less hours spent manually aggregating data and use reporting to create uniformity/alignment across departments.</p>
        </div>
        <div class="col">
        <div id="plus_minus_icon_parent">
            <img id="plus_minus_icons" src="' . __DIR__ . '/minus_svg.svg" />
        </div>
            <p>Teams who rely on manual reporting lack the ability to efficiently assess data quality as well as struggle to speak the same language across departments within the organization.</p>
        </div>
    </div>
    <div class="gradient-bottom">
    </div>

';
