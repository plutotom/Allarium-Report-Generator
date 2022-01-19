// Global params agf_handle_pdf_print: scored_entries, post_id

function agf_jgeneratePDF() {
  // posable depercated (js html to pdf, Does not handle css)
  // console.log(obj);
  // let user_email = "plutotom@Live.com";
  // let entry_id = "317";
  // let entry_to_print = "";
  // let entry_user_email = "";
  // // to upper case
  // user_email = user_email.toUpperCase();

  // // for each user in obj
  // for (let user in agf_handle_pdf_print.scored_entries) {
  //   // if (user.toUpperCase() === user_email) {
  //   // for each form in user
  //   for (let form in obj[user].forms) {
  //     // for each entry in form
  //     // console.log(obj[user].forms);
  //     for (let entry in obj[user].forms[form].entries) {
  //       // if entry_id matches entry_id
  //       if (obj[user].forms[form].entries[entry].entry_id === entry_id) {
  //         console.log("found entry");
  //         console.log(obj[user].forms[form].entries[entry]);
  //         entry_to_print = obj[user].forms[form].entries[entry];
  //         entry_user_email = user;
  //       }
  //     }
  //   }
  //   // }
  // }

  // // HTML table Template

  // // style for table
  // let html = `<style>
  //   /* variables go in here*/
  //   :root {
  //       --color1: #FFA600;
  //       --color2: #F29242;
  //       --color3: #eb7b1e;
  //       --color4: #FF764A;
  //       --white: #ffffff;
  //       --gray: #f3f3f3;
  //       --darkgray: #9e9e9e;
  //       --black: #242424;
  //   }
  //   /* example of use:
  //       body{
  //         background-color: var(--color4);
  //       }
  //   */
  //   body {
  //       font-family: 'Open Sans', 'Helvetica Neue', sans-serif, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  //       color: var(--black);
  //       font-size: 1em;
  //   }
  //   p {
  //       margin: 0;
  //       padding: 4px 0;
  //   }
  //   .result-cells {
  //       color: var(--white);
  //       font-weight: 800;
  //   }
  //   .container {
  //       width: 960px;
  //       margin: 0 auto;
  //       /* border: 1px solid #424242; */
  //       /* box-shadow: 0 0 5px var(--darkgray); */
  //       padding: 3em;
  //       padding-bottom: 0;
  //   }
  //   .intro-para {
  //       line-height: 1.6em;
  //       font-weight: 400;
  //       margin-bottom: 20px;
  //   }
  //   .results-tab{
  //       background-color: var(--color4);
  //       display: inline-block;
  //       padding: 1em 3em;
  //       margin-left: -3em;
  //       border-top-right-radius: 100px;
  //       border-bottom-right-radius: 100px;
  //       line-height: 1.3em;
  //   }
  //     /* "Your Results" text */
  //   h2{
  //       font-weight: bold;
  //       color: var(--white);
  //       font-size: 2em;
  //       margin: 0;
  //   }
  //   /* TABLE BEGINS HERE */
  //   .table-results {
  //       margin-top: 2em;
  //       border: 1px solid gray;
  //   }
  //   .border-color{
  //       border-bottom: 3px solid #FF764a;

  //   }
  //   table {
  //       margin: 0 auto;
  //       width: 100%;
  //       border-collapse: collapse;
  //   }
  //   th {
  //       padding: 1em 0;
  //       font-weight: 400;
  //   }
  //   th, td {

  //       margin: 0 auto;
  //       text-align: center;
  //       font-size: 1.5em;
  //   }

  //   td:not(:first-child) {
  //       color: var(--white);
  //       font-weight: 700;
  //       font-size: 1.8em;
  //   }
  //   .col-1{
  //       padding: .8em 1em;
  //       font-size: 1.5em;
  //       text-align: left;
  //       width: 30%;
  //       height: 125px;
  //   }

  //   .gray-cell{
  //       background-color: var(--gray);
  //       border: 1px solid white;
  //   }

  //   /* TABLE ENDS HERE */
  //   /*--------------Table Cell Color Specifics begin Here----------*/
  //   .Arow {background-color: var(--color1);}
  //   .Brow {background-color: var(--color2)}
  //   .Crow {background-color: var(--color3)}
  //   .Drow {background-color: var(--color4)}
  //   /*--------------Table Cell Color Specifics end Here----------*/

  //   .logo-row {
  //       width: 100%;
  //       margin: 3em 0;
  //   }
  //   div.logo-row img{
  //       width: 10%;
  //   }

  //   .gradient-bottom {
  //       background-image: linear-gradient(to right, #F7C35D, #D25B3C);
  //       padding: .5em 3em;
  //       width: 960px;
  //       margin: 0 auto;
  //   }

  // </style>`;
  // html += `<div class="container">
  //   <div>
  //       <h1>Capability Assessment Results</h1>
  //   </div>
  //   <div>
  //       <p class="intro-para">
  //           The Measured Capability Assessment is designed to map your current in-house data, measurement and decisioning capabilities to your business objectives. The results below highlight how you scored in each area. The following pages detail the characteristics of brands in each category. At the end of this document, you will the find the Capability Prioritization worksheet, which can be used to set the priorities of our engagement.
  //       </p>
  //   </div>
  //   <div class="results-tab">
  //       <h2>Your Results</h2>
  //   </div>

  //   <div class="table-results">
  //       <table>
  //       <!-- Table Row 1 Header -->
  //           <tr class="border-color">
  //               <th></Br></th>
  //               <th class="gray-cell">
  //                   <p>Contender<br>0%-39%</p>
  //               </th>
  //               <th class="gray-cell">
  //                   <p>Challenger
  //                       <br>40%-64%</p>
  //               </th>
  //               <th class="gray-cell">
  //                   <p>Leader
  //                       <br>65%-89%</p>
  //               </th>
  //               <th class="gray-cell">
  //                   <p>Champion
  //                       <br>90%+</p>
  //               </th>
  //           </tr>`;

  // html += `<!-- Table Row 2 - content -->
  //           <tr>
  //               <td class="col-1 gray-cell">`;
  // // for each category in entry_to_print categories
  // console.log(entry_to_print);
  // for (let category in entry_to_print.categories) {
  //   html = html + `<p>` + category + `</p>`;
  //   //   if()
  //   //   html += `</td>
  //   //   <td class="Arow">A1</td>
  //   //   <td>B1</td>
  //   //   <td>C1</td>
  //   //   <td>D1</td>
  //   // </tr>`;
  // }

  // html += `</table>
  //   </div>
  //   <!-- End Table -->

  //   <div class="logo-row">
  //       <!--  <img src="https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg"> -->
  //   </div>
  //   </div> <!-- End Container -->`;

  // // // put entry_to_print into html table
  // // var html = "<table>";
  // // html += "<tr>";
  // // html += "<th>User Email</th>";
  // // // for each category in entry_to_print
  // // for (var category in entry_to_print.categories) {
  // //   html += "<th>" + category + "</th>";
  // // }

  // // html += "</tr>";
  // // html += "<tr>";
  // // html += "<td>" + entry_user_email + "</td>";
  // // for (var category in entry_to_print.categories) {
  // //   html += "<td>" + entry_to_print.categories[category] + "</td>";
  // // }
  // // html += "</tr>";
  // // html += "</table>";

  // // let element = jQuery(".agf_testing_table")[0];

  // // var pdf = new jsPDF("p", "pt", "a4");
  // // pdf.addHTML(document.body, function () {
  // //   pdf.save("web.pdf");
  // // });
  // // html2canvas(document.body).then(function (canvas) {
  // //   var img = canvas.toDataURL("image/png");
  // //   var doc = new jsPDF();
  // //   doc.addImage(img, "JPEG", 10, 10);
  // //   doc.save("test.pdf");
  // // });
  // // var doc = new jsPDF(); //create jsPDF object
  // // doc.fromHTML(
  // //   // document.getElementById("agf_html_table"), // page element which you want to print as PDF
  // //   test,
  // //   15,
  // //   15,
  // //   {
  // //     width: 170, //set width
  // //   },

  // //   function (a) {
  // //     doc.save("${Client_name}_scores.pdf"); // save file name as HTML2PDF.pdf
  // //   }
  // // );

  // make ajax post request

  var data = {
    action: "agf_testing_table",
    data: {
      data: data,
    },
  };
  jQuery.post(ajaxagf_handle_pdf_print.ajax_url, data, function (response) {
    console.log(response);
  });
}
