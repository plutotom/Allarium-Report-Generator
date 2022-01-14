<?php
// This is the snippet from includes/metaboxes/views/list_forms_view.php:
// This is the part that will handle adding a category box, and have the 
// button for adding these boxes to list all questions.

// This is inserted under the list of gravity forms.
?>

<h1>List Questions</h1>
<button class="button button-primary button-large" id="add-question-category">Add Category</button>
<button onClick="agf_prepare_category_data(event, jQuery);" class="button button-primary button-large"
    id="ajax-request-button">save
    categories</button>




<h3>name of category goes here</h3>
<div class="col-12 col-md-8 container" id="list-question-category-container">

</div>
<div class="d-none" id="overlay"></div>

<!-- <button onClick="agf_js_pdf_print(event, jQuery)" class="button button-primary button-large"
    id="ajax-request-button-print">print res</button>

<?php 
// echo '<a href="'.AGFR__PLUGIN_DIR .'agf_print.php">run php</a>';