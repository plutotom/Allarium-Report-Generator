console.log("agf_dynatable_script.js loaded");
jQuery(document).ready(function ($) {
  $("#html-table")
    .bind("dynatable:init", function (e, dynatable) {
      dynatable.queries.functions["domainInput"] = function (
        record,
        queryValue
      ) {
        // get value after @ symble in recored.userEmail
        var domain = record.userEmail.split("@")[1];
        return domain === queryValue;
      };
      dynatable.queries.functions["userName"] = function (record, queryValue) {
        return queryValue === record.userName;
      };
    })
    .dynatable({
      features: {
        paginate: true,
        recordCount: false,
        sorting: true,
        search: true,
      },
      inputs: {
        queries: $("#domainInput, #userName"),
      },
    });
});
