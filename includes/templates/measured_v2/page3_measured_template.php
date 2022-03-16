<?php


$bi_score = $assessment_value_average['Marketing Experimentation'];
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
                <th class="overview-header"></th>
                <th class="overview-header ' . $Contender . '">Contender</th>
                <th class="overview-header ' . $Challenger . '">Challenger</th>
                <th class="overview-header ' . $Leader . '">Leader</th>
                <th class="overview-header ' . $Champion . '">Champion</th>

            /* Row 1 */
                <tr>
                    <td>Tactic Coverage</td>
                    <td class="' . $Contender . '">Has little or no in-market experimentation to test key hypotheses or validate marketing attribution.</td>
                    <td class="' . $Challenger . '">Has run some experimentation, most likely lift studies with key partners including but not limited to Facebook and Google, to validate incrementality and lift in some key channels.</td>
                    <td class="' . $Leader . '">Has validated incrementality and marketing attribution via in-market testing for the majority of key tactics in the marketing mix.</td>
                    <td class="' . $Champion . '">Regularly measures incrementality across the marketing mix via both always-on incrementality testing and point in time testing >2x per year for key marketing tactics.</td>
                </tr>

            /* Row 2 */
                <tr>
                    <td>Experimental Approaches</td>
                    <td class="' . $Contender . '">None or possibly a dated lift study.</td>
                    <td class="' . $Challenger . '">Runs periodic lift studies with key vendor partners but has done little independent incrementality measurement or has little faith in test outputs.</td>
                    <td class="' . $Leader . '">Regularly conducts incrementality testing across both first party audience splits and geo matched market testing. Has executed structured scale test to explore upside in a key tactic.</td>
                    <td class="' . $Champion . '">Has a comprehensive testing program including platform side audience splits, site-side testing, CRM testing, scale testing and rotating geo experimentation.</td>
                </tr>
            
            /* Row 3 */
                <tr>
                    <td>Experimental Learning Agenda</td>
                    <td class="' . $Contender . '">One or zero experiments in last 12 months.  No ongoing learning agenda.</td>
                    <td class="' . $Challenger . '">Has run ad hoc in-market experiments usually at the suggestion of agency or vendor partners. May have explored executing tests in a self-directed manner with mixed success.</td>
                    <td class="' . $Leader . '">Executes a quarterly experimentation roadmap w/ 3+ in-market experiments against key hypotheses. Revisits testing against largest marketing channels at least 1x yearly.</td>
                    <td class="' . $Champion . '">Testing program includes a mix of always-on testing for key channels, comprehensive plans for new channels, and a comprehensive quarterly learning agenda.</td>
                
                </tr>

                /* Row 4 */
                <tr>
                    <td>Application to Decisions</td>
                    <td class="' . $Contender . '">None</td>
                    <td class="' . $Challenger . '">Some tests have influenced budgeting and informed attribution, but application is inconsistent due to either lack of confidence or clear actionability of testing.</td>
                    <td class="' . $Leader . '">Testing influences attribution and has clear connections to budget decisions. Examples include validating investment in new marketing channels and significant budget changes for key tactics.</td>
                    <td class="' . $Champion . '">Testing actively feeds marketing attribution and hence all budgeting and decision making. Experimentation identifies and capitalizes on in-market opportunities in near time.</td>
                
                </tr>


        </table>
 



        
</div> <!-- End Container -->
    
    <div id="logo-row">
    <img src="' . __DIR__ . '/measured_icon.jpg" style="width: 32mm; height: 7mm; margin: 0;" />
    </div>
        <div class="overview-bottom" style="margin-top: 15px;">
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
