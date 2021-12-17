<?php


include  'views/list_selected_form_questions_view.php';

function agf_register_list_forms_metabox()
{
    add_meta_box(
        'agf_render_list_form_questions', // ID
        __('List All Form Questions', 'text_domain'), // Title
        'agf_render_list_form_questions_metabox', // call back function that renders html for view
        ['agfReport'], // the page it is to be called on. Also called screen.
        'advanced', // Context?
        'default'   // Priority
    );
}