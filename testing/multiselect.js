// http://loudev.com/#usage
// Passing $ from jQuary because wordpress runs jQuary in no conflict mode.

function addRow() {
  console.log("addRow");
  console.log(post_meta);
  console.log(jQuery("#input_area").val());

  // add div to the DOM
  // var div = document.createElement("div");
  // div.className = "row";
  // div.innerHTML =
  //   '<input type="text" name="input_area[]" value="' +
  //   jQuery("#input_area").val() +
  //   '" /> <a href="#" onclick="removeRow(this)">Remove</a>';
  // document.getElementById("input_area").appendChild(div);

  var new_category = document.createElement("div");
  new_category.className = "row";
  new_category.innerHTML = `<select multiple="multiple" id="my-select" name="my-select[]">
           foreach($form['fields'] as $field) {
               if(in_array($field['type'], $field_types)) {
                   echo '<option value="'.$field['id']." ". $field['label'] .'">'.$field['label'].'</option>';
               }
           }
     </select>`;
  document.getElementById("input_area").appendChild(new_category);

  // new_category.innerHTML = `<div class="row">
  //                <input type="text" name="name" value="" />
  //                <input type="text" name="value" value="" />
  //                <label><input type="checkbox" name="check" value="1" />Checked?</label>
  //                <input type="button" value="-" onclick="removeRow(this)">
  //                </div>`;
}
function removeRow(input) {
  input.parentNode.remove();
}

(function ($) {
  console.log("multi_select_js.js loaded");
  function addRow() {
    console.log("addRow");
    console.log($("#input_area").val());

    $("#input_area").insertAdjacentHTML(
      "afterbegin",
      `<div class="row">
                  <input type="text" name="name" value="" />
                  <input type="text" name="value" value="" />
                  <label><input type="checkbox" name="check" value="1" />Checked?</label>
                  <input type="button" value="-" onclick="removeRow(this)">
                  </div>`
    );
  }
  function removeRow(input) {
    input.parentNode.remove();
  }

  var selected_fields = [];

  // add value to selected_fields array when user selects an option
  $("#my-select").multiSelect({
    afterSelect: function (values) {
      selected_fields.push(values);
      console.log(selected_fields);

      console.log($("#my-select").find(":selected").val());
    },
    afterDeselect: function (values) {
      selected_fields.splice(selected_fields.indexOf(values), 1);
      console.log(selected_fields);
    },

    selectableHeader:
      "<input type='text' class='search-input' autocomplete='off' placeholder='Search'>",
    selectionHeader:
      "<input type='text' class='search-input' autocomplete='off' placeholder='Search'>",
    afterInit: function (ms) {
      var that = this,
        $selectableSearch = that.$selectableUl.prev(),
        $selectionSearch = that.$selectionUl.prev(),
        selectableSearchString =
          "#" +
          that.$container.attr("id") +
          " .ms-elem-selectable:not(.ms-selected)",
        selectionSearchString =
          "#" + that.$container.attr("id") + " .ms-elem-selection.ms-selected";

      that.qs1 = $selectableSearch
        .quicksearch(selectableSearchString)
        .on("keydown", function (e) {
          if (e.which === 40) {
            that.$selectableUl.focus();
            return false;
          }
        });

      that.qs2 = $selectionSearch
        .quicksearch(selectionSearchString)
        .on("keydown", function (e) {
          if (e.which == 40) {
            that.$selectionUl.focus();
            return false;
          }
        });
    },
    afterSelect: function () {
      this.qs1.cache();
      this.qs2.cache();
    },
    afterDeselect: function () {
      this.qs1.cache();
      this.qs2.cache();
    },
  });

  var formData = new FormData();
  formData.append("selected_fields", selected_fields);

  $("#select-all").click(function () {
    $("#my-select").multiSelect("select_all");
    return false;
  });
  $("#deselect-all").click(function () {
    $("#my-select").multiSelect("deselect_all");
    return false;
  });
})(jQuery);
