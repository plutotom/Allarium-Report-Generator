<?php



$bi_score = $entry_to_print_pg_1['categories']['Marketing Scale and Growth'];
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

$page_4_body = '
<div class="container">
    <div class="row">
        <div class="page2title">
           <h4>Marketing Scale <br>and Growth
           </h4>
        </div>
        <div class="results-tab2">
            <h2>Capability Overview </h2>
        </div>
    </div>

    <div class="row">
        <div class="intro-para2">
            <p>Marketing for Scale and Growth includes a balance of mastering the most-used channels, maximizing return, and diversifying efforts across additional channels. 
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
                    <td class="' . $Contender . '">We would like to spend more on Facebook, but can’t seem to generate cost effective volume, still in “growth hacking” mode.</td>
                    <td class="' . $Challenger . '">Have achieved some scale on Facebook and Google but are finding limited success in other channels. </td>
                    <td class="' . $Leader . '">Have achieved scale on FB/Google PPC and at least one other channel (>10% of mix). </td>
                    <td class="' . $Champion . '">Have achieved scale on FB/Google PPC and at least multiple other channels (>10% of mix). </td>
                </tr>

            /* Row 2 */
                <tr>
                    <td class="' . $Contender . '">90%+ of marketing spend concentrated in Google PPC/Facebook. Facebook is volume or CPA constrained i.e. </td>
                    <td class="' . $Challenger . '">Still have 85%+ in Google PPC/Facebook but are starting to dabble in other channels -></td>
                    <td class="' . $Leader . '">Google PPC/FB are 65%-85% of mix, dabbling in other marketing channels.</td>
                    <td class="' . $Champion . '">Google PPC/FB are <65%of mix.</td>
                </tr>
            
            /* Row 3 */
                <tr>
                    <td class="' . $Contender . '">No channels outside of affiliate, email, Google PPC and Facebook.</td>
                    <td class="' . $Challenger . '">Typically Podcast, OTT, influencer or other social channels, but sometimes DM.</td>
                    <td class="' . $Leader . '">Typically Podcast, OTT or other social channels, but sometimes DM.</td>
                    <td class="' . $Champion . '">Have mature marketing programs across 2+ other channels.</td>
                
                </tr>
            
                /* Row 4 */
                <tr>
                    <td class="' . $Contender . '"></td>
                    <td class="' . $Challenger . '"></td>
                    <td class="' . $Leader . '"></td>
                    <td class="' . $Champion . '"></td>
                
                </tr>


        </table>
    </div> 



    

        
</div> <!-- End Container -->

<div id="logo-row">
<img src="' . __DIR__ . '/measured_icon.jpg" style="width: 32mm; height: 7mm; margin: 0;" />
</div>
<div class="overview-bottom" style="">
            <div class="col">
                <!-- <div class="orangecir"></div> -->
                <p>Teams that have mastered Marketing for Scale and Growth have been able to scale with Facebook, Google, as well as additional channels with at least 35% of their efforts going towards other channels. 
                </p>
            </div>
            <div class="col">  
                <p>Teams who haven\'t yet been able to plan for Scale and Growth are not seeing a return that allows them to invest more in a particular channel. These teams usually are focused on one or few popular channels.</p>
            </div>
        </div>
<div class="gradient-bottom">
</div>';
