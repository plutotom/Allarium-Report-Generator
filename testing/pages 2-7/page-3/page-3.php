<?php

require_once __DIR__ . '/vendor/autoload.php';

$stylesheet =('<style>'.file_get_contents('D:\Users\Elizabeth\Desktop\new items - move me\BRCC SCHOOL\Work Folder\2021\Allarium\WORK\Measured\Isaiah\PDF-HTML\styles.css').'</style>');

$mpdf= new \Mpdf\Mpdf(['collapseBlockMargins ' => false, 'mode' => 'utf-8','format' => 'letter','margin_left' => 0,'margin_right' => 0,'margin_top' => 0,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]);

$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML('

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
                    <th class="overview-header ">Contender</th>
                    <th class="overview-header isSelected">Challenger</th>
                    <th class="overview-header ">Leader</th>
                    <th class="overview-header ">Champion</th>

                    /* Row 1 */
                        <tr>
                            <td>Has little or no in-market experimentation to test key hypotheses or validate marketing attribution.</td>
                            <td class="isSelected">Has run some experimentation, most likely lift studies with key partners including but not limited to Facebook and Google, to validate incrementality and lift in some key channels but does not have a thorough or comprehensive approach.  </td>
                            <td>Has comprehensively validated incrementality and marketing attribution via in-market testing for the vast majority of the marketing portfolio, only excluding channels that are not able to support in-market experimentation (e.g. influencer, affiliate, channels with insignificant spend).  </td>
                            <td>Has comprehensive always-on testing program including always-on testing, CRM testing, and rotating geo experimentation.</td>
                        </tr>

                    /* Row 2 */
                        <tr>
                            <td></td>
                            <td class="isSelected">Has run in-market experiments which are conducted ad hoc and usually at the suggestion of agency or vendor partners. Studies are sometimes conducted in a self-directed manner that goes beyond partnering with vendors on lift studies.</td>
                            <td>Executes a quarterly experimentation roadmap w/ 3+ in-market experiments against key hypotheses, e.g. geo match market, on site retargeting, CRM testing, audience split testing, etc.  Revisits testing against largest marketing channels at least 1x yearly. </td>
                            <td>Testing program includes a mix of always-on testing for key channels, validation and scale exploration in new channels, and a separate set of quarterly learning hypotheses to test against.  </td>
                        </tr>
                    
                    /* Row 3 */
                        <tr>
                            <td></td>
                            <td class="isSelected">There is no comprehensive testing plan or framework.</td>
                            <td>Uses testing to validate new marketing channels and explore scale where feasible.</td>
                            <td>Testing actively feeds and validates marketing attribution.  Testing actively feeds budgeting and decision making and is used to identify and capitalize on in-market opportunities in near time.</td>
                        
                        </tr>
                    <!--
                        /* Row 4 */
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        
                        </tr>
                    -->

                </table>
         

    
        
                
        </div> <!-- End Container -->



            
            <div id="logo-row">
            <img src="https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg">
            </div>
           
                <div class="overview-bottom" style="margin-top: 4em;">
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



');
$mpdf->Output();