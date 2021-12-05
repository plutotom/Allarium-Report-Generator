<?php

include("views/graph_view.php");
function agf_register_reporting_metabox()
{
    add_meta_box(
        'reporting-graph', // ID
        __('Reporting Graph', 'text_domain'), // Title
        'agf_render_graph_table_metabox', // call back function that renders html for view
        ['agfReport', 'post', 'page'], // the page it is to be called on. Also called screen.
        'advanced', // Context?
        'default'   // Priority
    );
}
