// Global Variables: agf_list_questions_metabox_obj: post_data, ajax_url, all_forms, all_entries

/**
 * Filter function to get only selected forms
 * @return {string} string that is unique id
 */
function agf_uid() {
  return Date.now().toString(36) + Math.random().toString(36).substring(2, 15);
}

/**
 * Search filter function for questions list.
 * @param {event} event onKeyDown event
 */

function agf_handel_search(event) {
  var input, filter, question_list, i, label, txtValue;
  console.log("opening the menu");
  input = event.target.value;
  current_id = event.target.id;
  filter = input.toUpperCase();
  question_list = document.getElementById(current_id);
  label = question_list.getElementsByTagName("label");
  for (i = 0; i < label.length; i++) {
    txtValue = label[i].textContent || label[i].innerText;
    if (txtValue.toUpperCase().indexOf(filter) > -1) {
      label[i].style.display = "";
    } else {
      //   label[i].style.display = "none"; // this was being overridden by some other css styles.
      label[i].setAttribute("style", "display: none !important");
    }
  }
}

/**
 *
 * @param {event} event on change event
 * @param {jQuery} $ jQuery object
 * @returns {object} object of categorys
 */

function agf_prepare_category_data(event, $) {
  event.preventDefault();
  console.log("Running agf_prepare_category_data");
  categories = [];
  $("#list-question-category-container")
    .find(".category-container")
    .each(function (index, item) {
      category_id = $(item).attr("id");
      categories[category_id] = item;
    });

  post_data = {};
  Object.values(categories).forEach((category, index, array) => {
    category_title = $(category).find("input[type=text]").val();
    category_id = $(category).attr("id");

    if (!post_data[category_id]) {
      // if this category id is not already in post_data then add it.
      post_data[category_id] = {
        category_questions: [],
        category_id: category_id,
        category_title: category_title.trim(),
      };
    }

    // get item child elements that are checkboxes
    $(category)
      .find("input[type=checkbox]")
      .each(function (index, question_input_element) {
        // listing all questions checkbox input elements.
        // If input element is checked then add its parent element label text to post_data
        if ($(question_input_element).is(":checked")) {
          // this is the label that is surrounding the question checkbox.
          var parent = $(question_input_element).parent();
          // This is the question text.
          var parent_text = parent.text();
          // remove white space on parent_text only at start and end.
          parent_text = parent_text.trim();
          // id of the category
          var item_id = $(question_input_element).attr("id");

          var question_class = $(question_input_element).attr("class");
          // get all text after space
          var form_id = question_class.split("form_id=")[1];
          var field_id = question_class.split("field_id=")[1];

          // making sure the value is not null
          if (field_id && field_id) {
            form_id = form_id.split(" ")[0];
          }

          if (!post_data[item_id]) {
            if (field_id && field_id) {
              post_data[category_id] = {
                category_questions: [
                  {
                    question_name: parent_text,
                    form_id: form_id,
                    field_id: field_id,
                  },
                ],
                category_id: category_id,
                category_title: category_title.trim(),
              };
            } // if no form id and no field id.
            post_data[category_id] = {
              category_questions: [parent_text],
              category_id: category_id,
              category_title: category_title.trim(),
            };
          } else {
            // if the item (category) is already in post_data then add the question to the category
            post_data[category_id].category_questions.push({
              question_name: parent_text,
              form_id: form_id,
              field_id: field_id,
            });
          }
        }
      });
  });

  // Sending data to update post meta
  agf_update_post_meta(event, $, post_data);
}

/**
 * Make Ajax request to update post meta data
 * @todo add wp nonce
 * @param {domEvent} event
 * @param {jQueryTag} $
 * @param {object} category_data - category data to update post meta with
 * @global agf_list_questions_metabox_obj.post_id
 * @return {response} weather or not the request was successful
 */

function agf_update_post_meta(event, $, category_data) {
  event.preventDefault();
  console.log("Running update post meta");
  console.log(category_data);

  //   making ajax request to update post meta
  $.ajax({
    url: agf_list_questions_metabox_obj.ajax_url,
    type: "POST",
    data: {
      action: "agf_update_post_meta",
      data: category_data,
      post_id: agf_list_questions_metabox_obj.post_id,
      nonce: agf_list_questions_metabox_obj.nonce,
    },
    success: function (response) {
      // update post meta data
      console.log(response);
      console.log("positive response");
      agf_score_entries($); // update scoring after category post meta is updated.
      return response;
    },
    error: function (response) {
      console.log(response);
      console.log("negative response");
      return response;
    },
  });
}

/**
 * Loads all saved categories, titles, and their selected questions into html.
 * @param {jQuery} $ jQuery object
 * @param {array} unique_questions - array of unique questions that is returned from agf_get_unique_questions.
 */
function agf_load_categories($, question_list) {
  var category_data = agf_list_questions_metabox_obj.post_data.category_data;
  let checked = "";
  function agf_is_checked(cq_arr, question_label) {
    const { length } = cq_arr;
    const id = length + 1;
    const found = cq_arr.some((item) => item.question_name === question_label);
    // if (!found) cq_arr.push({ id, username: question });
    return found; // found will be weather or not the question is in the array, i.e. if question should be checked.
  }
  // loading saved categories
  if (category_data) {
    Object.values(category_data).forEach((category, index, array) => {
      let load_question_list_html = "";
      if (category.category_questions) {
        question_list.forEach((question, index, array) => {
          if (agf_is_checked(category.category_questions, question["label"])) {
            checked = "checked";
          } else checked = "";
          load_question_list_html += `<label name="question-label" id="${category.category_id}" class="d-block agf-question-label">
              <input ${checked} name="question-checkbox[]" id="${category.category_id}" class="question-checkbox form_id=${question["formId"]} field_id=${question["id"]}"
                type="checkbox">&nbsp</input>
            ${question["label"]}</label>`;
        });
      } else {
        // if category.category_questions is empty do this
        question_list.forEach((question, index, array) => {
          load_question_list_html += `<label name="question-label" id="${category.category_id}" class="d-block agf-question-label">
              <input name="question-checkbox[]" id="${category.category_id}" class="question-checkbox form_id=${question["formId"]} field_id=${question["id"]}"
                type="checkbox">&nbsp</input>
            ${question["label"]}</label>`;
        });
      }

      var load_category_html = `<div id="${category.category_id}" class="col-12 col-md-8 container category-container">
        <input name="category-title[]" type="text" id="${category.category_id}" class="category-title"  placeholder="Category Name" value="${category.category_title}"/>

            <div class="category-${category.category_id} ${category.category_id}" id="category-${category.category_id} ${category.category_id}">

            <button onclick="agf_open_category_menu(event, jQuery);" id="agf-question-list-menu-dropdown" class="button button-primary button-large agf-question-list-menu-dropdown">
                Menu 1 &#9013;
            </button>
            <button onclick="agf_delete_category(event, jQuery);" id="${category.category_id}" class="btn btn-danger btn-large agr-delete-category-button">
            Delete Category
            </button>
            
            <div id="${category.category_id}" style="padding: 10px;" class="d-none shadow rounded agf-menu agf-question-list-div-with-search">

            <input onkeyup="agf_handel_search(event)" type="text" id="${category.category_id}"            class="agf-question-list-search" placeholder="Search Questions.." title="Type a question">
            <div class="question-list-div" id="${category.category_id}">
            ${load_question_list_html}
            </div>
            </div>
            </div>
            </div>
        </div>`;
      $("#list-question-category-container").append(load_category_html);
    }); // end category loop
  }
}

/**
 * Takes selected forms and gets their questions, only unique questions are returned
 * @param {boolean} unique - if true, only unique questions are returned, else returns array of all questions
 * @returns {array} - array of unique questions based on the selected forms.
 */

function agf_get_unique_questions(unique) {
  var all_forms = agf_list_questions_metabox_obj.all_forms;

  // converting array of ids from strings to ints
  var selected_forms_ids =
    agf_list_questions_metabox_obj.post_data.multi_selected_forms_ids.map(
      Number
    );
  var filtered_forms = all_forms.filter((form) =>
    selected_forms_ids.includes(form.id)
  );

  // for each question in the response, put it in the question_list
  // creating one big list of questions to filter through later.
  var question_list = [];
  filtered_forms.forEach(function (form) {
    form["fields"].forEach(function (field) {
      if (field["type"] === "survey" || field["type"] === "select") {
        question_list.push(field);
      }
    });
  }); // end loop of questions

  if (unique === true) {
    //* removing duplicate questions based on the questions label's last 12 characters.
    //* This is done because each question has a clients name in it therefor making all questions unique.
    //* Getting the last 12 characters of the label is enough to tell if it is unique most of the time.
    const unique_question_list = [
      ...new Map(
        question_list.map((item) => [item["label"].slice(-12), item])
      ).values(),
    ];
    return unique_question_list;
  }

  return question_list;
}

/**
 * Deletes the selected category.
 * @param {*} event
 * @param {jQuery} $
 */

function agf_delete_category(event, $) {
  event.preventDefault();
  console.log("Running delete category");
  var result = confirm("Want to delete?");
  if (!result) {
    return;
  }
  var category_id = event.target.id;
  var Category_data = agf_list_questions_metabox_obj.post_data.category_data;
  delete Category_data[category_id];
  $(`#${category_id}`).remove(); // removes every element with the id of category_id
  agf_prepare_category_data(event, $);
}

/**
 * Opens the menu dropdown that holds question list.
 * @param {event} event - event object
 */

function agf_open_category_menu(event, $) {
  event.preventDefault();
  var search_input = $(event.target).parent().find(".agf-question-list-search");

  console.log("Opening Menu");
  event.target.parentElement.children[2].classList.remove("d-none");
  document.getElementById("overlay").classList.remove("d-none");
  search_input[0].focus();
}

/**
 *
 * @param {int} form_id - the id of the form that the field id belongs to.
 * @param {int} field_id - the id of the desired field
 * @param {array} all_question_list - An array of all questions in all forms.
 * @returns {object} - The whole question object.
 */

function get_form_label_by_form_and_field_id(
  form_id,
  field_id,
  all_question_list
) {
  return all_question_list.filter((question) => {
    if (question.formId == form_id && question.id == field_id) {
      return question.label;
    }
  })[0];
}

/**
 * Scores gravity form entries based on created categories.
 * @param {jQuery} $ - jQuery object
//! * @param {array} form_questions_list - array of all questions in all forms.
 * @returns {obj} - object of scored data
 */

function agf_score_entries($, form_questions_list = []) {
  console.log("Scoring entries");
  $.ajax({
    url: agf_list_questions_metabox_obj.ajax_url,
    type: "POST",
    data: {
      action: "agf_score_entries",
      nonce: agf_list_questions_metabox_obj.nonce,
      post_id: agf_list_questions_metabox_obj.post_id,
    },
    success: function (response) {
      // console.log("success");
      console.log(response);
      agf_list_questions_metabox_obj.scored_entries = response;
    },
    error: function (error) {
      console.log("error");
      // console.log(error);
    },
  });
}

(function ($, window, document) {
  ("use strict");
  // execute when the DOM is ready
  $(document).ready(function () {
    const questions_list = agf_get_unique_questions(false);

    agf_list_questions_metabox_obj.scoring_values_schema = {
      glikertcol2079ce3b4: 0, // completely disagree
      glikertcol2afb99d83: 1, // Mostly disagree
      glikertcol2c8b03172: 2, // Somewhat Disagree
      glikertcol2705122be: 3, // Somewhat Agree
      glikertcol297044e96: 4, // Mostly Agree
      glikertcol25100bcbb: 5, // Completely Agree
      glikertcol25156cc64: null, // N/A
    };
    agf_list_questions_metabox_obj.question_list = questions_list;
    console.log(agf_list_questions_metabox_obj);
    agf_load_categories($, questions_list);
    agf_score_entries($);

    //! Adding html category box on button click
    $("#add-question-category").on("click", function (event) {
      event.preventDefault();
      const category_uid = agf_uid();

      // Put all questions in to html
      var question_list_html = "";
      agf_list_questions_metabox_obj.question_list.forEach(function (question) {
        question_uid = agf_uid();
        question_list_html += `<label name="question-label" id="${category_uid}" class="d-block agf-question-label">
            <input name="question-checkbox[]" id="${category_uid}" class="question-checkbox form_id=${question["formId"]} field_id=${question["id"]}" type="checkbox">&nbsp</input>
            ${question["label"]}</label>`;
      });
      var category_html = `<div id="${category_uid}" class="col-12 col-md-8 container category-container">
          <input name="category-title[]" type="text" id="${category_uid}" class="category-title"  placeholder="Category Name"/>
        
          <div class="category-div ${category_uid}" id="${category_uid}">
        
            
            <button onclick="agf_open_category_menu(event, jQuery);" id="${category_uid}" class="agf-question-list-menu-dropdown button button-primary button-large">
            Menu 1 &#9013; </button>
           
            <button onclick="agf_delete_category(event, jQuery);" id="${category_uid}" class="btn btn-danger btn-large agr-delete-category-button">
            Delete Category
            </button>

            
            
            <div id="${category_uid}" style="padding: 10px;" class="d-none shadow rounded agf-menu agf-question-list-div-with-search">

              <input onkeyup="agf_handel_search(event)" type="text" id="${category_uid}" class="agf-question-list-search" placeholder="Search Questions.." title="Type a question">
              <div class="question-list-div" id="${category_uid}">
                ${question_list_html}
              </div>
            </div>
          </div>
        </div>`;
      $("#list-question-category-container").append(category_html);
      agf_prepare_category_data(event, $);
    }), // end of add-question-category button click
      //! Hiding menu drop down on click outside
      $("#overlay").on("click", function (event) {
        event.preventDefault();
        console.log("Hiding");
        agf_prepare_category_data(event, $);

        //* resetting the search input
        var items = document.getElementsByClassName("agf-menu");
        var search = document.getElementsByClassName(
          "agf-question-list-search"
        );
        // for each search set value to empty
        for (var i = 0; i < search.length; i++) {
          search[i].value = "";
        }
        // for each agf-question-label set style to display: ""
        var questions = document.getElementsByClassName("agf-question-label");
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
  }); // end document ready
})(jQuery, window, document);
