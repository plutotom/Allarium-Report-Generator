function agf_open_category_menu(event, $) {
  event.preventDefault();
  var search_input = $(event.target).parent().find(".agf-question-list-search");

  console.log("Opening Menu");
  event.target.parentElement.children[2].classList.remove("d-none");
  document.getElementById("overlay").classList.remove("d-none");
  search_input[0].focus();
}

//! Hiding menu drop down on click outside
function overlay_click_handler(event) {
  //   var overlay = document.getElementById("overlay");
  //   var dropdown = document.getElementById("agf-question-list-dropdown");
  //   dropdown.classList.add("d-none");
  //   overlay.classList.add("d-none");

  console.log("Hiding");
  //* resetting the search input
  var items = document.getElementsByClassName("agf-menu");
  var search = document.getElementsByClassName("agf-question-list-search");
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
 * Search filter function for questions list.
 * @param {event} event onKeyDown event
 */

function agf_handel_search(event) {
  var input, filter, parent, i, label, txtValue;
  input = event.target.value;

  filter = input.toUpperCase();
  search_element = document.getElementById(event.target.id);

  // get parent element of search input
  parent = search_element.parentElement;
  label = parent.getElementsByTagName("label");

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
