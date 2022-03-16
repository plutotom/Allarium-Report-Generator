<?php


$page_6_body = '<div class="container">
      <div style="margin: 0; padding: 0;" class="row">
        <h3 style="margin: 0; padding: 0;">Initial Capability Prioritization
        </h3>
      </div>
      <div style="margin-top: -2em; margin-bottom: 0;" class="row">
        <div class="intro-para" style="margin-bottom: 0;">
          <p>
            Prioritization helps your team stay focused on your achieving your
            in-house capability goals. Measured will revisit these priorities
            with your team as you continue to make progress.
          </p>
        </div>
      </div>';

$entry_to_print = $entry_to_print_pg_6_prioritization['categories'];

// for each category, add the score as a percentage in a new bar-row
foreach ($entry_to_print as $key => $value) {
  // Agf_Helper_Class::console_log($value);
  $value_percent = $value / 9; // this is the max of the scoring schema
  $value_percent = $value_percent * 100;
  $value_percent = round($value_percent, 2);
  $display_val = null;


  // if value is less then 5 the width will be set to 100%. Width can not take values less then 5%.
  if ($value_percent == 0) {
    $display_val = 'display: none';
    $value_percent_width = $value_percent;
  }
  if ($value_percent < 5) {
    $value_percent_width = 5;
  }
  if ($value_percent > 75) {
    $value_percent_width = 75;
  } else {
    $value_percent_width = $value_percent;
  }

  $page_6_body .= '
    <div style="margin: 25px 0" class="bar-row">
        <div class="rowleft">
          <h4 class="color1">' . $value_percent . '%</h4>
          <h4>' . $key . '</h4>
        </div>
        <div class="rowright-1" style="width: ' . $value_percent_width . '%; ' . $display_val . '">
          <br />
        </div>
    </div>';
  if (strtoupper($key) == strtoupper('Centralized Data and BI Reporting')) {
    $page_6_body .= '<p>
    Top Priority Task: Standing up a cross-channel marketing and attribution reporting hub
    </p>';
  } else if (strtoupper($key) == strtoupper('Marketing Scale and Growth')) {
    $page_6_body .= '<p>
    Top Priority Task: Add new marketing channels to my mix
    </p>';
  } else if (strtoupper($key) == strtoupper('Data-Driven Decision Making')) {
    $page_6_body .= '<p>
    Top Priority Task: Better forecast marketing investment required to hit my business goals
    </p>';
  } else if (strtoupper($key) == strtoupper('Marketing Experimentation')) {
    $page_6_body .= '<p>
      Top Priority Task: Validate Inc% of my Facebook or Google programs
    </p>';
  }
  $page_6_body .= '<div class="bar-row topprioritytask" style="margin: -2em 0">
     </div>';
}

// measured SVG icon (not working with mpdf)
// get file contetn from https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg
// get_file_content("https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg");
// "data:image/png;base64,'.base64_encode(file_get_contents($url_res)).'"

// $svg_file = file_get_contents('https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg');
// $find_string   = '<svg';
// $position = strpos($svg_file, $find_string);
// $svg_file_new = substr($svg_file, $position);

$page_6_body .= '
</div> <!-- End Container -->

<div id="logo-row">
</div>

<div class="gradient-bottom">
</div>';
// <img src="' . __DIR__ . '/measured_icon.jpg" style="width: 32mm; height: 7mm; margin: 0;" />
