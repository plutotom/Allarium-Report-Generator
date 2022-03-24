<?php



$bi_score = $assessment_value_average['Data-Driven Decision Making'];
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


$page_5_body = '
<div class="container">
    <div class="row">
        <div class="page2title">
           <h4>Data-Driven <br>Decision Making
           </h4>
        </div>
        <div class="results-tab2">
            <h2>Capability Overview </h2>
        </div>
    </div>

    <div class="row">
        <div class="intro-para2">
            <p>Data-driven marketing is the process by which marketers glean insights and trends by analyzing company-generated or market data, then translating these insights into actionable decisions informed by the numbers.

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
                    <td>Marketing Attribution</td>
                    <td class="' . $Contender . '">Google Analytics and/or vendor platforms taken as truth with specific window “rules” used to determine attribution, e.g. Google DDA or 7d click/1d view in Facebook Ads Manager.</td>
                    <td class="' . $Challenger . '">Relies on Google Analytics and Vendor platforms for attribution, but ad hoc adjustments are made to accounts for things like funnel position and new vs. existing customers.</td>
                    <td class="' . $Leader . '">Uses either an internally built attribution model (e.g. MTA, MMM) or actively adjusts Google Analytics/Vendor Reporting with results from in-market testing.</td>
                    <td class="' . $Champion . '">Uses regular incrementality testing to train attribution models (e.g. MMM or MTA).</td>
                </tr>

            /* Row 2 */
                <tr>
                    <td>Cross-Channel Budget Allocation</td>
                    <td class="' . $Contender . '">Budgets are done ad hoc; some combo of “What did we do last year?” and “What are our goals this year?”.</td>
                    <td class="' . $Challenger . '">Budgets based on metrics driven by finance targets like CAC (total spend/total new customers) or % of total revenue.</td>
                    <td class="' . $Leader . '">Budgets are fluid if hitting efficiency targets allowing money to flow into high performing tactics. Consideration made for seasonality and pacing to goals.</td>
                    <td class="' . $Champion . '">Marketing budgets are fluid but progress to goal is carefully tracked via weekly forecasts  and assessments are made as to how budget changes will impact goal achievement.</td>
                </tr>
            
            /* Row 3 */
                <tr>
                    <td>Channel Level Campaign Management</td>
                    <td class="' . $Contender . '">Targets set at the channel level with adjustments to daily campaign budgets based on performance, experience and seasonality.</td>
                    <td class="' . $Challenger . '">Targets are adjusted to account for funnel position or new vs. existing. Budgets are adjust weekly based on combination of performance and pacing to goals.</td>
                    <td class="' . $Leader . '">CPA/ROAS targets set at the tactic level inclusive of incrementality. Bids/Budgets adjusted weekly based on pacing to goals and always-on testing.</td>
                    <td class="' . $Champion . '">CPA/ROAS targets at the campaign level inclusive of incrementality.  Bids/Budgets adjusted based on forecasting, always-on testing or automated bidding.</td>
                
                </tr>
            
                /* Row 4 */
                <tr>
                    <td>Business Forecasting</td>
                    <td class="' . $Contender . '">Ad-Hoc or Annual</td>
                    <td class="' . $Challenger . '">Quarterly Excel Based Exercise</td>
                    <td class="' . $Leader . '">Monthly Model Based Exercise</td>
                    <td class="' . $Champion . '">Always-on automated forecasting with weekly updates.</td>
                
                </tr>


        </table>
    </div> 



    

        
</div> <!-- End Container -->

<div id="logo-row">
<img src="' . __DIR__ . '/measured_icon.jpg" style="width: 32mm; height: 7mm; margin: 0;" />
</div>
<div class="overview-bottom" style="margin-top: 126px; font-size: .9em; padding-bottom: 3em;">
            <div class="col">
                <!-- <div class="orangecir"></div> -->
                <div id="plus_minus_icon_parent">
                <img id="plus_minus_icons" src="' . __DIR__ . '/plus_svg.svg" />
            </div>
                <p>Teams that have mastered Data-Driven Decision Making have always-on testing that provides a direct link between results and planning so that actionable decisions can be optimized. 
                </p>
            </div>
            <div class="col">
            <div id="plus_minus_icon_parent">
            <img id="plus_minus_icons" src="' . __DIR__ . '/minus_svg.svg" />
        </div>
                
                <p>Teams who take GA reports as the whole truth may be lacking in effective strategy ands could suffer from heavy assumptions leading planning rather than concrete data.</p>
            </div>
        </div>
<div class="gradient-bottom">
</div>


';
