<?php


$page_6_styles = '<style>
    /* variables go in here*/
    :root {
        #FF764A: #FF764A;
        #FFA600: #FFA600;
        #F29242: #F29242;
        #ffffff: #ffffff;
        #f3f3f3: #f3f3f3;
        #9e9e9e: #9e9e9e;
        #242424: #242424;
    }
    /* example of use:
        body{
          background-color: #FF764A;
        }
    */
    body {
        font-family: "Open Sans", "Helvetica Neue", sans-serif, "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        color: #242424;
        font-size: 1em;
    }
    p {
        margin: 0;
        padding: 4px 0;
        font-size: 1.3em;
        line-height: 1.4em;
    }
    .result-cells {
        color: #ffffff;
        font-weight: 800;
    }
    .container {
        width: 960px; 
        margin: 0 auto;
        border: 1px solid #424242;
        box-shadow: 0 0 5px };
        padding: 3em;
        padding-bottom: 0;
    }
    .intro-para {
        line-height: 1.6em;
        font-weight: 400;
        margin: 3em 0;
        float: left;
        width: 100%;

    }
    .intro-para2 {
        line-height: 1.6em;
        font-weight: 400;
        font-size: 1.1em;
        width: 60%;
        display: block;
        float: left;
        margin: 3em 0;
    }
    .row{
        display: block;
        width: 100%;
        margin: 30px 0;
    }
    .results-tab2{
        background-color: #FF764A;
        display: block;
        float: right;
        align-items: center;
        margin-right: -3em;
        padding: 2em 6em 2em 3em;
        width: 40%;
        
        border-top-left-radius: 100px;
        border-bottom-left-radius: 100px;
        line-height: 1.3em;
        
    }
      /* "Your Results" h2 text */
    h2{
        font-weight: bold;
        color: #ffffff;
        font-size: 2em;
        margin: 0;
    }
    h1, h3{
        font-size: 2.5em;
        margin: 0;
        float: left;
        width: 100%;
    }
    h4{
        font-size: 1.5em;
        margin: .5em 0;
    }
    .discussion {
        border: 1px solid #FF764A;
        padding: 1em;
        margin: 0 auto;
        margin-top: 3em;
        width: 35%;
        text-align: left;
        float: right;

    }
    .discussion p {
        text-transform: uppercase; 
        font-weight: 700; 
        letter-spacing: .2em;
      
    }
    ul {
        line-height: 2em;
        list-style: none;
        margin-bottom: -5px;
    }
    ul li::before {
        content: "\2022";
        display: inline-block;
        color: #FF764A;
        width: 1.6em;
        margin-left: -1em;
        font-weight: 800;
    }
    /* TABLE BEGINS HERE */
    .table-results {
        margin-top: 2em;
        border: 1px solid gray;
    }
    .border-color{
        border-bottom: 3px solid #FF764a;

    }
    table {
        margin: 0 auto;
        width: 100%;
        border-collapse: collapse;
    }
    th {
        padding: 1em 0;
        font-weight: 400;
    }
    th, td {

        margin: 0 auto;
        text-align: center;
        font-size: 1.5em;
    }

    td:not(:first-child) {
        color: #ffffff;
        font-weight: 700;
        font-size: 1.8em;
    }
    .col-1{
        padding: .8em 1em;
        font-size: 1.5em;
        text-align: left;
        width: 30%;
        height: 125px;
    }

    .gray-cell{
        background-color: #f3f3f3;
        border: 1px solid white;
    }

    /* TABLE ENDS HERE */
    /*--------------Table Cell Color Specifics begin Here----------*/
    .Arow {background-color: #FFA600)}
    .Brow {background-color: #F29242}
    .Crow {background-color: #F29242}
    .Drow {background-color: #FF764A}
    /*--------------Table Cell Color Specifics end Here----------*/

    .logo-row {
        width: 100%;
        margin: 3em 0;
    }
    div.logo-row img{
        width: 10%;
    }

    .gradient-bottom {
        background-image: linear-gradient(to right, #F7C35D, #D25B3C);
        padding: .5em 3em;
        width: 960px;
        margin: 0 auto;
    }

    /*------------- page 6 graphs row-------------*/
    .bar-row{
        display: block;
        margin: 35px 0;
        width: 100%;
      
    }
    .rowleft {
        
        width: 25%;
        height: 152.8px;
        background-color: #f6f6f6;
        display: inline-block;
        padding: 0 .5em;
      
    }
    .rowright-1 {
        width: 70%;
        height: 152.8px;
        vertical-align: top;
        background-color: #FF764A);    
        display: inline-block;

    }
    .rowright-2 {
        width: 60%; 
        height: 152.8px;
        vertical-align: top;
        background-color: #FF764A;
        display: inline-block;
    }
    .rowright-3 {
        width: 20%; 
        height: 152.8px;
        vertical-align: top;
        background-color: #FF764A;
        display: inline-block;
    }
    .rowright-4 {
        width: 20%; 
        height: 152.8px;
        vertical-align: top;
        background-color: #FF764A;
        display: inline-block;
    }
    .color1{
        color: #FF764A;
        font-size: 26px;
        
    } 

    .topprioritytask{
        padding: 0 1em 1em 1em;
        font-size: .9em;
        font-weight: 300;
    }

</style>';

// width: 70%;
// background-color: #ff764a;


$page_6_body = '<div class="container">
      <div class="row">
        <h3>Capability Prioritization</h3>
      </div>

      <div class="row">
        <div class="intro-para">
          <p>
            Prioritization helps your team stay focused on your achieving your
            in-house capability goals. Measured will revisit these priorities
            with your team as you continue to make progress.
          </p>
        </div>
      </div>';

      $table_not_used = '<!-- graph rows begin here -->
      <div class="bar-row">
        <div class="rowleft">
          <h4 class="color1">18 Points</h4>
          <h4>Centralized Data and BI Reporting</h4>
        </div>
        <div class="rowright-1">
          <br />
        </div>
      </div>
      <div class="bar-row topprioritytask" style="margin: -2em 0">
        <p>
          Top Priority Task: Standing up a cross-channel marketing and
          attribution reporting hub
        </p>
      </div>

      <div class="bar-row">
        <div class="rowleft">
          <h4 class="color1">17 Points</h4>
          <h4>Market Experimentation</h4>
        </div>
        <div class="rowright-2">
          <br />
        </div>
      </div>
      <div class="bar-row topprioritytask" style="margin: -2em 0">
        <p>
          Top Priority Task: Validate Inc% of my Facebook or Google programs
        </p>
      </div>

      <div class="bar-row">
        <div class="rowleft">
          <h4 class="color1">5 Points</h4>
          <h4>Marketing Scale and Growth</h4>
        </div>
        <div class="rowright-3">
          <br />
        </div>
      </div>
      <div class="bar-row topprioritytask" style="margin: -2em 0">
        <p>Top Priority Task: Add new marketing channels to my mix</p>
      </div>

      <div class="bar-row">
        <div class="rowleft">
          <h4 class="color1">5 Points</h4>
          <h4>Data-Driven Decision Making</h4>
        </div>
        <div class="rowright-4">
          <br />
        </div>
      </div>
      <div class="bar-row topprioritytask" style="margin: -2em 0">
        <p>
          Top Priority Task: Better forecast marketing investment required to
          hit my business goals
        </p>
      </div>

      <div class="logo-row">
        <img
          src="https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg"
        />
      </div>
    </div>
    <!-- End Container -->
    <div class="gradient-bottom"></div>';






// categories:
// Foundations: 3.88
// Organization: 5
// Systems: 3.5
$entry_to_print = $entry_to_print['categories'];

// for each category, add the score as a percentage in a new bar-row
foreach ($entry_to_print as $key => $value) {
  Agf_Helper_Class::console_log($value);
  $value_percent = $value/5;
  $value_percent = $value_percent*100;
  $value_percent = round($value_percent, 2);
  $display_val = null;
  Agf_Helper_Class::console_log($value_percent);
  // if value is less then 5 the width will be set to 100%. Width can not take values less then 5%.
  if($value_percent == 0 ) {
    $display_val = 'none';
    $value_percent_width = $value_percent;
  }elseif($value_percent < 5){
    $value_percent_width = 5;
  }else{
    $value_percent_width = $value_percent;
  }
  $page_6_body .= '
    <div class="bar-row">
        <div class="rowleft">
          <h4 class="color1">' . $value_percent . '%</h4>
          <h4>' . $key . '</h4>
        </div>
        <div style="width: '.$value_percent_width.'%;
        background-color: #ff764a; display: '.$display_val.'">
          <br />
        </div>
    </div>
     <div class="bar-row topprioritytask" style="margin: -2em 0">
   <p>
     Top Priority Task: Standing up a cross-channel marketing and
     attribution reporting hub
   </p>
 </div>';
}


$page_6_body .= '
<div class="logo-row">
  <img
    src="https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg"
  />
</div>
</div>
<!-- End Container -->
<div class="gradient-bottom"></div>';