<?php


$bi_score = $entry_to_print_pg_1_assessment['categories']['Marketing Experimentation'];
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
$page_3_body = '
<div class="container">
    <div class="row">
        <div class="page2title">
           <h4>Marketing <br>Experimentation</h4>
        </div>
        <div class="results-tab2">
            <h2>Capability Overview</h2>
        </div>
    </div>

    <div class="row">
        <div class="intro-para2">
            <p>Marketing experimentation is a research method which can be defined as "the act of conducting such an investigation or test." It includes a design of experiments (DoE) for testing a channel, audience or market to quantify impact, explore scale or discover new opportunities.
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


  
    
       <table class="overview-table">
            <tr>
            <th class="overview-header ' . $Contender . '">Contender</th>
                <th class="overview-header ' . $Challenger . '">Challenger</th>
                <th class="overview-header ' . $Leader . '">Leader</th>
                <th class="overview-header ' . $Champion . '">Champion</th>

            /* Row 1 */
                <tr>
                    <td class="' . $Contender . '">Has little or no in-market experimentation to test key hypotheses or validate marketing attribution.</td>
                    <td class="' . $Challenger . '">Has run some experimentation, most likely lift studies with key partners including but not limited to Facebook and Google, to validate incrementality and lift in some key channels but does not have a thorough or comprehensive approach.  </td>
                    <td class="' . $Leader . '">Has comprehensively validated incrementality and marketing attribution via in-market testing for the vast majority of the marketing portfolio, only excluding channels that are not able to support in-market experimentation (e.g. influencer, affiliate, channels with insignificant spend).  </td>
                    <td class="' . $Champion . '">Has comprehensive always-on testing program including always-on testing, CRM testing, and rotating geo experimentation.</td>
                </tr>

            /* Row 2 */
                <tr>
                    <td class="' . $Contender . '"></td>
                    <td class="' . $Challenger . '">Has run in-market experiments which are conducted ad hoc and usually at the suggestion of agency or vendor partners. Studies are sometimes conducted in a self-directed manner that goes beyond partnering with vendors on lift studies.</td>
                    <td class="' . $Leader . '">Executes a quarterly experimentation roadmap w/ 3+ in-market experiments against key hypotheses, e.g. geo match market, on site retargeting, CRM testing, audience split testing, etc.  Revisits testing against largest marketing channels at least 1x yearly. </td>
                    <td class="' . $Champion . '">Testing program includes a mix of always-on testing for key channels, validation and scale exploration in new channels, and a separate set of quarterly learning hypotheses to test against.  </td>
                </tr>
            
            /* Row 3 */
                <tr>
                    <td class="' . $Contender . '"></td>
                    <td class="' . $Challenger . '">There is no comprehensive testing plan or framework.</td>
                    <td class="' . $Leader . '">Uses testing to validate new marketing channels and explore scale where feasible.</td>
                    <td class="' . $Champion . '">Testing actively feeds and validates marketing attribution.  Testing actively feeds budgeting and decision making and is used to identify and capitalize on in-market opportunities in near time.</td>
                
                </tr>
            <!--
                /* Row 4 */
                <tr>
                    <td class="' . $Contender . '"></td>
                    <td class="' . $Challenger . '"></td>
                    <td class="' . $Leader . '"></td>
                    <td class="' . $Champion . '"></td>
                
                </tr>
            -->

        </table>
 



        
</div> <!-- End Container -->
    
    <div id="logo-row">
    <img src="' . __DIR__ . '/measured_icon.jpg" style="width: 32mm; height: 7mm; margin: 0;" />
    </div>
        <div class="overview-bottom" style="margin-top: 180px;">
            <div class="col">
                <!-- <div class="orangecir"></div> -->
                <p>Teams that have mastered Marketing Experimentation have diversified their outreach and use ongoing testing to ensure that results drive decisions.</p>
            </div>
            <div class="col">
                <p>Teams who do not utilize Marketing Experimentation to drive decisions may be missing out on opportunities to scale within various channels.</p>
            </div>
        </div>
        <div class="gradient-bottom">
</div>

';
