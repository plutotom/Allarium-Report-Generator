<?php

require_once __DIR__ . '/../vendor/autoload.php';
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

$html = '<!-- <title>Capability Assessment Results</title> -->
    <style>        
        /* example of use:
            body{
                background-color: #ff764a;
            }
        */
        body {
        font-family: "Open Sans", "Helvetica Neue", sans-serif, "Segoe UI", Tahoma,
            Geneva, Verdana, sans-serif;
        color: #242424;
        font-size: 1em;
        }
        p {
        margin: 0;
        padding: 4px 0;
        }
        .result-cells {
        color: #ffffff;
        font-weight: 800;
        }
        .container {
        width: 960px;
        margin: 0 auto;
        /* border: 1px solid #424242; */
        /* box-shadow: 0 0 5px #9e9e9e; */
        padding: 3em;
        padding-bottom: 0;
        }
        .intro-para {
        line-height: 1.6em;
        font-weight: 400;
        margin-bottom: 20px;
        }
        .results-tab {
        background-color: #ff764a;
        display: inline-block;
        padding: 1em 3em;
        margin-left: -3em;
        border-top-right-radius: 100px;
        border-bottom-right-radius: 100px;
        line-height: 1.3em;
        }
        /* "Your Results" text */
        h2 {
        font-weight: bold;
        color: #ffffff;
        font-size: 2em;
        margin: 0;
        }
        /* TABLE BEGINS HERE */
        .table-results {
        margin-top: 2em;
        border: 1px solid gray;
        }
        .border-color {
        border-bottom: 3px solid #ff764a;
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
        th,
        td {
        margin: 0 auto;
        text-align: center;
        font-size: 1.5em;
        }

        td:not(:first-child) {
        color: #ffffff;
        font-weight: 700;
        font-size: 1.8em;
        }
        .col-1 {
        padding: 0.8em 1em;
        font-size: 1.5em;
        text-align: left;
        width: 30%;
        height: 125px;
        }

        .gray-cell {
        background-color: #f3f3f3;
        border: 1px solid white;
        }

        /* TABLE ENDS HERE */
        /*--------------Table Cell Color Specifics begin Here----------*/
        .Arow {
        background-color: #ffa600;
        }
        .Brow {
        background-color: #f29242;
        }
        .Crow {
        background-color: #eb7b1e;
        }
        .Drow {
        background-color: #ff764a;
        }
        /*--------------Table Cell Color Specifics end Here----------*/

        .logo-row {
        width: 100%;
        margin: 3em 0;
        }
        div.logo-row img {
        width: 10%;
        }

        .gradient-bottom {
        background-image: linear-gradient(to right, #f7c35d, #d25b3c);
        padding: 0.5em 3em;
        width: 960px;
        margin: 0 auto;
        }
    </style>
    <div class="container">
    <div>
        <h1>Capability Assessment Results</h1>
    </div>
    <div>
        <p class="intro-para">
            The Measured Capability Assessment is designed to map your current in-house data, measurement and decisioning capabilities to your business objectives. The results below highlight how you scored in each area. The following pages detail the characteristics of brands in each category. At the end of this document, you will the find the Capability Prioritization worksheet, which can be used to set the priorities of our engagement.
        </p>
    </div>
    <div class="results-tab">
        <h2>Your Results</h2>
    </div>

    <div class="table-results">
        <table>
            <!-- Table Row 1 -->
            <tr class="border-color">
                <th></Br></th>
                <th class="gray-cell">
                    <p>Contender<br>0%-39%</p>
                </th>
                <th class="gray-cell">
                    <p>Challenger
                        <br>40%-64%</p>
                </th>
                <th class="gray-cell">
                    <p>Leader
                        <br>65%-89%</p>
                </th>
                <th class="gray-cell">
                    <p>Champion
                        <br>90%+</p>
                </th>
            </tr>
            <!-- Table Row 2 -->
            <tr>
                <td class="col-1 gray-cell">
                    <p>Centralized Data<br> and BI Reporting</p>
                </td>
                <td class="Arow">A1</td>
                <td>B1</td>
                <td>C1</td>
                <td>D1</td>
            </tr>
            <!-- Table Row 3 -->
            <tr>
                <td class="col-1 gray-cell">
                    <p>Marketing<br> Experimentation</p>
                </td>
                <td>A2</td>
                <td >B2</td>
                <td class="Crow">C2</td>
                <td>D2</td>
            </tr>
            <!-- Table Row 4 -->
            <tr>
                <td class="col-1 gray-cell">
                    <p>Marketing Scale <br> and Growth</p>
                </td>
                <td>A3</td>
                <td>B3</td>
                <td>C3</td>
                <td class="Drow">D3</td>
            </tr>
            <!-- Table Row 5 -->
            <tr>
                <td class="col-1 gray-cell">
                    <p>Data-Driven<br>  Decision Making</p>
                </td>
                <td>A4</td>
                <td class="Brow">B4</td>
                <td>C4</td>
                <td>D4</td>
            </tr>
        </table>
    </div>
    <!-- End Table -->



    <div class="logo-row">
        <img src="https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg">
    </div>
    </div> <!-- End Container -->
<div class="gradient-bottom"></div>';


$obj = '{
    "plutotom@live.com": {
      forms: [
        {
          entries: [
            {
              categories: {
                Foundations: 2.82,
                Organization: 3.38,
                Systems: 2.25,
              },
              entry_id: "317",
            },
            {
              categories: {
                Foundations: 2.24,
                Organization: 2.13,
                Systems: 2.25,
              },
              entry_id: "316",
            },
          ],
          form_id: "8",
        },
        {
          entries: [
            {
              categories: {
                Foundations: 4,
              },
              entry_id: "360",
            },
            {
              categories: {
                Foundations: 2.18,
              },
              entry_id: "359",
            },
          ],
          form_id: "11",
        },
      ],
    },
    "isaiah.proctor@allarium.com": {
      forms: [
        {
          entries: {
            2: {
              categories: {
                Foundations: 2.24,
                Organization: 2.13,
                Systems: 2.25,
              },
              entry_id: "315",
            },
            3: {
              categories: {
                Foundations: 2.24,
                Organization: 2.13,
                Systems: 2.25,
              },
              entry_id: "314",
            },
          },
          form_id: "8",
        },
        {
          entries: {
            2: {
              categories: {
                Foundations: 2.18,
              },
              entry_id: "358",
            },
            3: {
              categories: {
                Foundations: 2.18,
              },
              entry_id: "357",
            },
            4: {
              categories: {
                Foundations: 2.18,
              },
              entry_id: "356",
            },
            5: {
              categories: {
                Foundations: 2.18,
              },
              entry_id: "355",
            },
            6: {
              categories: {
                Foundations: 2.18,
              },
              entry_id: "354",
            },
            7: {
              categories: {
                Foundations: 2.18,
              },
              entry_id: "353",
            },
            8: {
              categories: {
                Foundations: 2.18,
              },
              entry_id: "352",
            },
            9: {
              categories: {
                Foundations: 2.18,
              },
              entry_id: "351",
            },
            10: {
              categories: {
                Foundations: 2.18,
              },
              entry_id: "350",
            },
          },
          form_id: "11",
        },
      ],
    },
}';
$obj = json_decode($obj, true);

echo $obj;






$mpdf = new \Mpdf\Mpdf(['tempDir' => __DIR__ . '/', 'm~ode' => 'utf-8',
    // 'format' => [960, 300],
    'orientation' => 'P'
]);





// print_r($_REQUEST);
if($_REQUEST['thing'] === 'true'){
    $mpdf->WriteHTML($html);
    $mpdf->AddPage(); //equivalents e.g. <pagebreak /> and AddPage():
    $mpdf->Output();
}


// echo a tag with link
echo '<a href="test.php?thing=true" target="_blank">runf php</a>';