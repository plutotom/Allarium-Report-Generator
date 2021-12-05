<?php

include  'views/list_forms_view.php';

function agf_register_list_forms_metabox()
{
    add_meta_box(
        'agf_list_forms', // ID
        __('List forms', 'text_domain'), // Title
        'agf_render_list_form_metabox', // call back function that renders html for view
        ['agfReport'], // the page it is to be called on. Also called screen.
        'advanced', // Context?
        'default'   // Priority
    );
}
