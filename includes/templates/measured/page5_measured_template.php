<?php



$bi_score = $entry_to_print_pg_1['categories']['Data-Driven Decision Making'];
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
            <th class="overview-header ' . $Contender . '">Contender</th>
                <th class="overview-header ' . $Challenger . '">Challenger</th>
                <th class="overview-header ' . $Leader . '">Leader</th>
                <th class="overview-header ' . $Champion . '">Champion</th>

            /* Row 1 */
                <tr>
                    <td class="' . $Contender . '">Google Analytics and/or vendor platforms are taken as truth, windows may be tailored to get to a “real” impact, i.e.  we judge everything based on GA DDA  performance or 7c/1v in-platform performance, etc.</td>
                    <td class="' . $Challenger . '">Ad hoc CPA adjustment at the channel or tactic level to account for “funnel position”.  E.g. grossing up Google Analytics numbers for Facebook to account for VT, different targets for prospecting vs. retargeting or branded vs. non-branded search.*  </td>
                    <td class="' . $Leader . '">CPA/ROAS targets at the tactic level inclusive of incrementality and based on a strategic financial target (break even on 1st purchase, one-time LTV analysis, etc.). </td>
                    <td class="' . $Champion . '">CPA/ROAS targets at the tactic level inclusive of incrementality and based on an ongoing LTV assessment framework (both predictive and with channel level assessments). </td>
                </tr>

            /* Row 2 */
                <tr>
                    <td class="' . $Contender . '">Budgets are done ad hoc, some combo of “What did we do last year?” and “What are our goals this year?”.</td>
                    <td class="' . $Challenger . '">Budgets based on metrics driven by finance targets like CAC (total spend/total new customers) or % of total revenue. </td>
                    <td class="' . $Leader . '">Marketing budgets are typically fluid as long as they are meeting prescribed goals allowing money to flow into high performing tactics and channels. </td>
                    <td class="' . $Champion . '">Marketing budgets are fluid but progress to goal is carefully tracked and assessments are made as to how budget changes will impact goal achievement. </td>
                </tr>
            
            /* Row 3 */
                <tr>
                    <td class="' . $Contender . '"></td>
                    <td class="' . $Challenger . '">Some heavily assumption based spreadsheet exercise is used to forecast budgets and/or financial targets. </td>
                    <td class="' . $Leader . '">A formalized data driven  business forecasting exercise is likely done on a quarterly basis.</td>
                    <td class="' . $Champion . '">Business forecasts are automated and “always-on” inclusive of last week’s performance.</td>
                
                </tr>
            
                /* Row 4 */
                <tr>
                    <td class="' . $Contender . '"></td>
                    <td class="' . $Challenger . '" style="font-size: .8em; font-style: italic; vertical-align: bottom;">*Usually these are done in a “back of the envelope” manner, based on rules of thumb.
                    </td>
                    <td class="' . $Leader . '">Targets may be relaxed or tightened ad hoc based on “feel”, e.g. performance assessment, need to drive more demand, seasonality etc. </td>
                    <td class="' . $Champion . '">Key performance indicators and trends and/or promotions/events are used to restrict/relax targets to take advantage of over/under performing channels and business seasonality on a weekly (or more frequent basis) based on key performance indicators.  </td>
                
                </tr>


        </table>
    </div> 



    

        
</div> <!-- End Container -->

<div id="logo-row">
<img src="' . __DIR__ . '/measured_icon.jpg" style="width: 32mm; height: 7mm; margin: 0;" />
</div>
<div class="overview-bottom" style="font-size: .9em; padding-bottom: 3em;">
            <div class="col">
                <!-- <div class="orangecir"></div> -->
                <p>Teams that have mastered Marketing for Scale and Growth have been able to scale with Facebook, Google, as well as additional channels with at least 35% of their efforts going towards other channels. 
                </p>
            </div>
            <div class="col">
                
                <p>Teams who haven’t yet been able to plan for Scale and Growth are not seeing a return that allows them to invest more in a particular channel. These teams usually are focused on one or few popular channels.</p>
            </div>
        </div>
<div class="gradient-bottom">
</div>


';
