<?php

require_once __DIR__ . '/vendor/autoload.php';

$stylesheet =('<style>'.file_get_contents('D:\Users\Elizabeth\Desktop\new items - move me\BRCC SCHOOL\Work Folder\2021\Allarium\WORK\Measured\Isaiah\PDF-HTML\styles.css').'</style>');

$mpdf= new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4','margin_left' => 0,'margin_right' => 0,'margin_top' => 0,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]);

$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML('

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
                    <th class="overview-header ">Contender</th>
                    <th class="overview-header ">Challenger</th>
                    <th class="overview-header ">Leader</th>
                    <th class="overview-header isSelected">Champion</th>

                    /* Row 1 */
                        <tr>
                            <td>We would like to spend more on Facebook, but can’t seem to generate cost effective volume, still in “growth hacking” mode.</td>
                            <td>Have achieved some scale on Facebook and Google but are finding limited success in other channels. </td>
                            <td>Have achieved scale on FB/Google PPC and at least one other channel (>10% of mix). </td>
                            <td class="isSelected">Have achieved scale on FB/Google PPC and at least multiple other channels (>10% of mix). </td>
                        </tr>

                    /* Row 2 */
                        <tr>
                            <td>90%+ of marketing spend concentrated in Google PPC/Facebook. Facebook is volume or CPA constrained i.e. </td>
                            <td>Still have 85%+ in Google PPC/Facebook but are starting to dabble in other channels -></td>
                            <td>Google PPC/FB are 65%-85% of mix, dabbling in other marketing channels.</td>
                            <td class="isSelected">Google PPC/FB are <65%of mix.</td>
                        </tr>
                    
                    /* Row 3 */
                        <tr>
                            <td>No channels outside of affiliate, email, Google PPC and Facebook.</td>
                            <td>Typically Podcast, OTT, influencer or other social channels, but sometimes DM.</td>
                            <td>Typically Podcast, OTT or other social channels, but sometimes DM.</td>
                            <td class="isSelected">Have mature marketing programs across 2+ other channels.</td>
                        
                        </tr>
                    
                        /* Row 4 */
                        <tr>
                            <td class=""></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        
                        </tr>


                </table>
            </div> 

    
    
            

                
        </div> <!-- End Container -->

        <div id="logo-row">
        <img src="https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg">
    </div>
        <div class="overview-bottom" style="margin-top: 19em;">
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



');
$mpdf->Output();