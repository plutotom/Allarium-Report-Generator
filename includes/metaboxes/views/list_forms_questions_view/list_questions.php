<?php
// This is the snippet from includes/metaboxes/views/list_forms_view.php:
// This is the part that will handle adding a category box, and have the 
// button for adding these boxes to list all questions.

// This is inserted under the list of gravity forms.
?>

<h1>List Questions</h1>
<button class="button button-primary button-large" id="add-question-category">Add Category</button>


<div class="container">
    <div class="col mb-2" id="list-question-category-container">
    </div>
</div>
<div class="d-none" id="overlay"></div>

<!-- <button onClick="agf_js_pdf_print(event, jQuery)" class="button button-primary button-large"
    id="ajax-request-button-print">print res</button>

<?php 



    // <div class="col-md-6">
    //   <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
    //     <div class="col p-4 d-flex flex-column position-static">
    //       <strong class="d-inline-block mb-2 text-primary">World</strong>
    //       <h3 class="mb-0">Featured post</h3>
    //       <div class="mb-1 text-muted">Nov 12</div>
    //       <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
    //       <a href="#" class="stretched-link">Continue reading</a>
    //     </div>
    //     <div class="col-auto d-none d-lg-block">
    //       <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>

    //     </div>
    //   </div>
    // </div>
    