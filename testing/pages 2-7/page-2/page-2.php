<?php

require_once __DIR__ . '/vendor/autoload.php';

$stylesheet = ('<style>' . file_get_contents('D:\Users\Elizabeth\Desktop\new items - move me\BRCC SCHOOL\Work Folder\2021\Allarium\WORK\Measured\Isaiah\PDF-HTML\styles.css') . '</style>');
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'letter', 'margin_left' => 0, 'margin_right' => 0, 'margin_top' => 0, 'margin_bottom' => 0, 'margin_header' => 0, 'margin_footer' => 0]);

$mpdf->WriteHTML($stylesheet, 1);
$mpdf->WriteHTML('

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
                    <th class="overview-header isSelected">Contender</th>
                    <th class="overview-header ">Challenger</th>
                    <th class="overview-header ">Leader</th>
                    <th class="overview-header ">Champion</th>

                    /* Row 1 */
                        <tr>
                            <td class="isSelected">Has no centralized reporting and no automated data.</td>
                            <td>Has no centralized reporting and no automated data.</td>
                            <td>Has implemented a centralized data warehouse with multiple data sets.</td>
                            <td>Has implemented a centralized data lake across all key data sets with daily updates and quality control.</td>
                        </tr>

                    /* Row 2 */
                        <tr>
                            <td class="isSelected">Numerous people check numerous vendor dashboards, e.g. Google Ads, Shopify, AdsManager, etc</td>
                            <td>Has started to standardize reports, i.e. same reports created on same cadence.</td>
                            <td>Has begun to standardize reporting, possibly using a BI tool, e.g. looker, tableau, etc. Has a siloed approach where different parts of the organization may use difference approaches.</td>
                            <td>Has standardized reporting via a centralized BI tool aligned across the organization.</td>
                        </tr>
                    
                    /* Row 3 */
                        <tr>
                            <td class="isSelected">Some manual ad hoc reporting using excel or ppt.</td>
                            <td>Reports are created manually in excel or ppt.</td>
                            <td>There is a mix of manual ad hoc and standardized reporting.</td>
                            <td>Automated  report generation and data collection.</td>
                        
                        </tr>
                    
                        /* Row 4 */
                        <tr>
                            <td class="isSelected">Ad hoc.</td>
                            <td>Reporting cadence is bi-weekly to monthly.</td>
                            <td>Reporting cadence is weekly to bi-weekly.</td>
                            <td>Has automated weekly reports sent daily or weekly.</td>
                        
                        </tr>


                </table>
            </div> 
            
        </div> <!-- End Container -->

        <div id="logo-row">
        <img src="https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg">
    </div>
        <div class="overview-bottom" style="margin-top: 10em">
                    <div class="col">
                        <!-- <div class="orangecir"></div> -->
                        <p>Teams that have mastered Centralized Data and  BI Reporting benefit from consistent quality control, less hours spent manually aggregating data and use reporting to create uniformity/alignment across departments.</p>
                    </div>
                    <div class="col">
                        
                        <p>Teams who rely on manual reporting lack the ability to efficiently assess data quality as well as struggle to speak the same language across departments within the organization.</p>
                    </div>
                </div>
        <div class="gradient-bottom">
        </div>



');
$mpdf->Output();
