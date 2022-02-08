<?php

require_once __DIR__ . '/vendor/autoload.php';

$stylesheet =('<style>'.file_get_contents('D:\Users\Elizabeth\Desktop\new items - move me\BRCC SCHOOL\Work Folder\2021\Allarium\WORK\Measured\Isaiah\PDF-HTML\styles.css').'</style>');

$mpdf= new \Mpdf\Mpdf(['autoPadding' => 'false', 'mode' => 'utf-8','format' => 'A4','margin_left' => 0,'margin_right' => 0,'margin_top' => 0,'margin_bottom' => 0,'margin_header' => 0,'margin_footer' => 0]);

$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML('

        <div class="container" style="padding: 3em;">
            <div class="row">
                
                   <h4 class="skinnyheader">Capability Improvement Roadmap</h4>
               
            
                <div class="page7para">
                    <p>Data-driven marketing is the process by which marketers glean insights and trends by analyzing company-generated or market data, then translating these insights into actionable decisions informed by the numbers.
                    </p>
                </div>
            </div>
                    
      
            <div class="row">
                <p class="timelineh2">Capability Improvement Timeline<p>
                <p class="timelineh3">Reporting</p>
                <img src="timeline-graphic.svg" style="margin-bottom: 5em;">
            </div> 
            
            <div class="row">
                <p class="timelineh2">Capability Improvement Timeline<p>
                <p class="timelineh3">Marketing Experimentation</p>
                <img src="timeline-graphic.svg" style="margin-bottom: 5em;">
             </div> 

             <div class="row">
                <p class="timelineh2">Capability Improvement Timeline<p>
                <p class="timelineh3">Marketing Scale and Growth</p>
                <img src="timeline-graphic.svg" style="margin-bottom: 5em;">
             </div> 

             <div class="row">
                <p class="timelineh2">Capability Improvement Timeline<p>
                <p class="timelineh3">Data-Driven Decision Making</p>
                <img src="timeline-graphic.svg">

      
             </div> 

            

            
    
    
            

                
        </div> <!-- End Container -->

        <div id="logo-row">
        <img src="https://pbs.twimg.com/profile_images/1117879307680903168/Sik09CMF_400x400.png">
    </div>
    
        <div class="gradient-bottom">
        </div>



');
$mpdf->Output();