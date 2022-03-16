<?php


$page_title_body = null;


// get todays date
$today = date("m.d.Y");

// make a html title page with image at the top, company name in the middle and the date at the bottom
$page_title_body = '
    <div>
        <div class="container">
            <div class="row" >
                <div style="margin: auto; width: 100%; text-align: center; padding: 10px;">
                        <div class="logo-row">
                            <img src="' . __DIR__ . '/measured_icon.jpg" style="width: 65mm; height: 14mm; margin: 0;" />
                        </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h1 style="padding-top:50px;">' . $_POST["company_name"] . '</h1>
                            <h1>Capability Assessment Results</h1>
                            <h1 class="" style="padding-top: 100px;">' . $today . '</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Container -->
    </div> <!-- End top most div -->
    <div id="logo-row">
        <img src="' . __DIR__ . '/measured_icon.jpg" style="width: 32mm; height: 7mm; margin: 0;" />
    </div>
    
    <div class="gradient-bottom">
    </div>';







$page_title_body .= '';
