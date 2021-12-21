// Global Variables: agf_list_questions_metabox_obj: post_data, url, all_forms

/**
 * Filter function to get only selected forms
 * @param {array} selected_forms Array of selected forms
 * @param {array} all_forms Array of all posable forms
 * @return {array} Array of currently selected forms
 */
function filter_selected_forms(selected_forms, all_forms) {
  return selected_forms === null ? "got it" : "not have it";
}

(function ($, window, document) {
  ("use strict");
  // execute when the DOM is ready
  $(document).ready(function () {
    //! Adding html category box on button click
    $("#add-question-category").on("click", function (event) {
      event.preventDefault();

      var selected_forms =
        agf_list_questions_metabox_obj.post_data.multi_selected_forms;
      console.log(selected_forms);
      //   JSON.parse(json_string);

      const filtered_forms = filter_selected_forms(
        agf_list_questions_metabox_obj.all_forms,
        selected_forms
      );

      // for each question in the response, put it in the question_list
      // creating one big list of questions to filter through later.
      var question_list = [];
      filtered_forms.forEach(function (form) {
        form["fields"].forEach(function (field) {
          if (field["type"] === "survey") {
            question_list.push(field);
          }
        });
      }); // end loop of questions

      //* removing duplicate questions based on the questions label's last 12 characters.
      //* This is done because each question has a clients name in it therefor making all questions unique.
      //* Getting the last 12 characters of the label is enough to tell if it is unique most of the time.
      const unique_question_list = [
        ...new Map(
          question_list.map((item) => [item["label"].slice(-12), item])
        ).values(),
      ];
      // put all questions in to html
      var question_list_html = "";
      unique_question_list.forEach(function (question) {
        question_list_html += `<span class="d-block agf-menu-option">
            <input class="question-input" type="checkbox" value="${"get saved value"}">&nbsp</input>
            ${question["label"]}</span>`;
      });

      // generate uid
      var uid =
        Math.random().toString(36).substring(2, 15) +
        Math.random().toString(36).substring(2, 15);
      var category_html = `<div id="category-container-${"category_id"}" class="col-12 col-md-8 container">
        <input type="text" class="question-input-title" name="category" placeholder="Category Name"/>
            <div class="category-${"category_id"}" id="category-${"category_id"} ${uid}">
            <button onclick="event.preventDefault();" id="agf-question-list-menu-dropdown" class="agf-question-list-menu-dropdown" >
                Menu 1 &#9013;
            </button>
            <div id=${uid} class="d-none shadow rounded agf-menu agf-question-list-div">
            <input onkeydown="return event.key != 'Enter';" type="text" id="${uid}" class="agf-question-list-search" placeholder="Search Questions.." title="Type a question">
            <span class="d-block agf-menu-option">
            ${question_list_html}
                
            </div>
            </div>
            </div>
        </div>`;
      $("#list-question-category-container").append(category_html);
    }),
      //! Handling the click event to add menu drop down
      $("#list-question-category-container").on(
        "click",
        "button",
        function (event) {
          event.preventDefault();
          console.log("opening the menu");
          // Open the menu
          event.target.parentElement.children[1].classList.remove("d-none");
          document.getElementById("overlay").classList.remove("d-none");
        }
      );

    //! Hiding menu drop down on click outside
    $("#overlay").on("click", function (event) {
      event.preventDefault();
      console.log("Hiding");

      //* resting the search input
      var items = document.getElementsByClassName("agf-menu");
      var search = document.getElementsByClassName("agf-question-list-search");
      // for each search set value to empty
      for (var i = 0; i < search.length; i++) {
        search[i].value = "";
      }
      // for each agf-menu-option set style to display: ""
      var questions = document.getElementsByClassName("agf-menu-option");
      for (var i = 0; i < questions.length; i++) {
        questions[i].style.display = "";
      }

      //* close the menu
      var items = document.getElementsByClassName("agf-menu");
      for (let i = 0; i < items.length; i++) {
        items[i].classList.add("d-none");
      }
      document.getElementById("overlay").classList.add("d-none");
    });

    //! Handling search for drop down question list
    $("#list-question-category-container").on(
      "keyup",
      "input",
      function (event) {
        event.preventDefault();
        console.log("opening the menu");
        // Searching
        var input, filter, qlist, i, span, txtValue;
        //   input = document.getElementsByClassName("agf-question-list-search");
        input = event.target.value;
        current_id = event.target.id;
        filter = input.toUpperCase();
        qlist = document.getElementById(current_id);
        span = qlist.getElementsByTagName("span");
        for (i = 0; i < span.length; i++) {
          txtValue = span[i].textContent || span[i].innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            span[i].style.display = "";
          } else {
            //   span[i].style.display = "none"; // this was being overridden by some other css styles.
            span[i].setAttribute("style", "display: none !important");
          }
        }
      }
    );

    //! Making ajax request to get all post type data
    // js 'click' event triggered on the click of the 'add new category' button.
    $("#add-question-category").click("click", function (event) {
      event.preventDefault();

      // jQuery post method, a shorthand for $.ajax with POST
      console.log("running ajax");
      //TODO get current category's, and post them when ever a user edits them.

      var qcid = Math.floor(Math.random() * 1000000);
      data = {
        action: "add_question_category",
        qcid,
        // value = value.append($("#current_select").val()),
      };

      $.post(agf_list_questions_metabox_obj.url, data, function (res) {
        console.log("js response");
        console.log(res);
      });
    }); // end ajax request
  }); // end document ready
})(jQuery, window, document);
