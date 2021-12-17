// make ajax request to get all post type data.

/*jslint browser: true, plusplus: true */
(function ($, window, document) {
  ("use strict");
  // execute when the DOM is ready
  $(document).ready(function () {
    // add category HTML on btn click
    $("#add-question-category").on("click", function (event) {
      event.preventDefault();
      var category_html = `<div id="category_group_${id}" class="category_question_group">
        <input type="text"  value="${"category.name"}" onkeydown="return event.key != 'Enter';" />
        <h3>Questions</h3>
        <p>Click on questions to be included in this category.</p>
        <select multiple>
            <option>${"category.name1"}</option>
            <option>${"category.name2"}</option>
        </select>
      </div>`;
      $("#list-question-category-container").append(category_html);
    }),
      // js 'click' event triggered on the click of the 'add new category' button.
      $("#add-question-category").click("click", function (event) {
        event.preventDefault(); // preventing form submission.
        // jQuery post method, a shorthand for $.ajax with POST

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
      });
  });
})(jQuery, window, document);
