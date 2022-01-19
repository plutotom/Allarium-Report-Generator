// Global params agf_handle_pdf_print: scored_entries, post_id

function agf_jgeneratePDF() {
  // posable depercated (js html to pdf, Does not handle css)
  console.log(obj);
  let user_email = "plutotom@Live.com";
  let entry_id = "317";
  let entry_to_print = "";
  let entry_user_email = "";
  // to upper case
  user_email = user_email.toUpperCase();

  // for each user in obj
  for (let user in agf_handle_pdf_print.scored_entries) {
    // if (user.toUpperCase() === user_email) {
    // for each form in user
    for (let form in obj[user].forms) {
      // for each entry in form
      // console.log(obj[user].forms);
      for (let entry in obj[user].forms[form].entries) {
        // if entry_id matches entry_id
        if (obj[user].forms[form].entries[entry].entry_id === entry_id) {
          console.log("found entry");
          console.log(obj[user].forms[form].entries[entry]);
          entry_to_print = obj[user].forms[form].entries[entry];
          entry_user_email = user;
        }
      }
    }
    // }
  }

  // HTML table Template

  html += `<div class="container">
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
        <!-- Table Row 1 Header -->
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
            </tr>`;

  html += `<!-- Table Row 2 - content -->
            <tr>
                <td class="col-1 gray-cell">`;
  // for each category in entry_to_print categories
  console.log(entry_to_print);
  for (let category in entry_to_print.categories) {
    html = html + `<p>` + category + `</p>`;
    //   if()
    //   html += `</td>
    //   <td class="Arow">A1</td>
    //   <td>B1</td>
    //   <td>C1</td>
    //   <td>D1</td>
    // </tr>`;
  }

  html += `</table>
    </div>
    <!-- End Table -->

    <div class="logo-row">
        <!--  <img src="https://www.measured.com/wp-content/uploads/2021/04/measured-logotext.svg"> -->
    </div>
    </div> <!-- End Container -->`;

  // // put entry_to_print into html table
  // var html = "<table>";
  // html += "<tr>";
  // html += "<th>User Email</th>";
  // // for each category in entry_to_print
  // for (var category in entry_to_print.categories) {
  //   html += "<th>" + category + "</th>";
  // }

  // html += "</tr>";
  // html += "<tr>";
  // html += "<td>" + entry_user_email + "</td>";
  // for (var category in entry_to_print.categories) {
  //   html += "<td>" + entry_to_print.categories[category] + "</td>";
  // }
  // html += "</tr>";
  // html += "</table>";

  // let element = jQuery(".agf_testing_table")[0];

  // var pdf = new jsPDF("p", "pt", "a4");
  // pdf.addHTML(document.body, function () {
  //   pdf.save("web.pdf");
  // });
  // html2canvas(document.body).then(function (canvas) {
  //   var img = canvas.toDataURL("image/png");
  //   var doc = new jsPDF();
  //   doc.addImage(img, "JPEG", 10, 10);
  //   doc.save("test.pdf");
  // });
  // var doc = new jsPDF(); //create jsPDF object
  // doc.fromHTML(
  //   // document.getElementById("agf_html_table"), // page element which you want to print as PDF
  //   test,
  //   15,
  //   15,
  //   {
  //     width: 170, //set width
  //   },

  //   function (a) {
  //     doc.save("${Client_name}_scores.pdf"); // save file name as HTML2PDF.pdf
  //   }
  // );

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
