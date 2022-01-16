// Global params agf_ajax_pdf_print_obj: ajax_url, nonce
function agf_generatePDF() {
  //   let div = document.createElement("div");
  //   div.innerHTML = "<p>CreateElement example</p>";
  //   //   document.body.appendChild(div);

  const element = document.getElementById("agf_invoice");
  var opt = {
    margin: 1,
    filename: "myfile.pdf",
    image: { type: "jpeg", quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: "in", format: "letter", orientation: "portrait" },
  };

  // New Promise-based usage:
  html2pdf().set(opt).from(element).save();
}
function agf_generateCanvious() {
  var element = document.getElementById("agf_invoice");
  html2canvas(element).then(function (canvas) {
    document.body.appendChild(canvas);
  });
}

function agf_jgeneratePDF() {
  var doc = new jsPDF(); //create jsPDF object
  console.log("running jpdf");
  doc.fromHTML(
    // document.getElementById("agf_html_table"), // page element which you want to print as PDF
    html,
    15,
    15,
    {
      width: 170, //set width
    },

    function (a) {
      doc.save("${Client_name}_scores.pdf"); // save file name as HTML2PDF.pdf
    }
  );
  console.log("finished running jpdf");
}
