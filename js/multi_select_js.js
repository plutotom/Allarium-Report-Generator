// http://loudev.com/#usage
// Passing $ from jQuary because wordpress runs jQuary in no conflict mode.

(function ($) {
  console.log("multi_select_js.js loaded");

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

(function ($) {
  console.log("multi_select_js.js loaded");
})(jQuery);
