<?php

require_once __DIR__ . '/vendor/autoload.php';

$stylesheet =('<style>'.file_get_contents('D:\Users\Elizabeth\Desktop\new items - move me\BRCC SCHOOL\Work Folder\2021\Allarium\WORK\Measured\Isaiah\PDF-HTML\styles.css').'</style>');

$mpdf= new \Mpdf\Mpdf(['mode' => 'utf-8','format' => 'A4','margin_left' => 0,'margin_right' => 0,'margin_top' => 0,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]);

$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML('

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
                    <th class="overview-header isSelected">Contender</th>
                    <th class="overview-header ">Challenger</th>
                    <th class="overview-header ">Leader</th>
                    <th class="overview-header ">Champion</th>

                    /* Row 1 */
                        <tr>
                            <td class="isSelected">Google Analytics and/or vendor platforms are taken as truth, windows may be tailored to get to a “real” impact, i.e.  we judge everything based on GA DDA  performance or 7c/1v in-platform performance, etc.</td>
                            <td>Ad hoc CPA adjustment at the channel or tactic level to account for “funnel position”.  E.g. grossing up Google Analytics numbers for Facebook to account for VT, different targets for prospecting vs. retargeting or branded vs. non-branded search.*  </td>
                            <td>CPA/ROAS targets at the tactic level inclusive of incrementality and based on a strategic financial target (break even on 1st purchase, one-time LTV analysis, etc.). </td>
                            <td>CPA/ROAS targets at the tactic level inclusive of incrementality and based on an ongoing LTV assessment framework (both predictive and with channel level assessments). </td>
                        </tr>

                    /* Row 2 */
                        <tr>
                            <td class="isSelected">Budgets are done ad hoc, some combo of “What did we do last year?” and “What are our goals this year?”.</td>
                            <td>Budgets based on metrics driven by finance targets like CAC (total spend/total new customers) or % of total revenue. </td>
                            <td>Marketing budgets are typically fluid as long as they are meeting prescribed goals allowing money to flow into high performing tactics and channels. </td>
                            <td>Marketing budgets are fluid but progress to goal is carefully tracked and assessments are made as to how budget changes will impact goal achievement. </td>
                        </tr>
                    
                    /* Row 3 */
                        <tr>
                            <td></td>
                            <td>Some heavily assumption based spreadsheet exercise is used to forecast budgets and/or financial targets. </td>
                            <td>A formalized data driven  business forecasting exercise is likely done on a quarterly basis.</td>
                            <td>Business forecasts are automated and “always-on” inclusive of last week’s performance.</td>
                        
                        </tr>
                    
                        /* Row 4 */
                        <tr>
                            <td class=""></td>
                            <td style="font-size: .8em; font-style: italic; vertical-align: bottom;">*Usually these are done in a “back of the envelope” manner, based on rules of thumb.
                            </td>
                            <td>Targets may be relaxed or tightened ad hoc based on “feel”, e.g. performance assessment, need to drive more demand, seasonality etc. </td>
                            <td>Key performance indicators and trends and/or promotions/events are used to restrict/relax targets to take advantage of over/under performing channels and business seasonality on a weekly (or more frequent basis) based on key performance indicators.  </td>
                        
                        </tr>


                </table>
            </div> 

    
    
            

                
        </div> <!-- End Container -->

        <div id="logo-row">
        <img src="https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg">
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



');
$mpdf->Output();