<?php

/**
 * Register a custom post type called "Report".
 *
 * @see get_post_type_labels() for label keys.
 */

function agf_init()
{
    $labels = array(
        'name'                  => _x('AGF Report', 'Post type general name', 'textdomain'),
        'singular_name'         => _x('Report', 'Post type singular name', 'textdomain'),
        'menu_name'             => _x('AGF Report', 'Admin Menu text', 'textdomain'),
        'name_admin_bar'        => _x('Report', 'Add New on Toolbar', 'textdomain'),
        'add_new'               => __('Add New', 'textdomain'),
        'add_new_item'          => __('Add New Report', 'textdomain'),
        'new_item'              => __('New Report', 'textdomain'),
        'edit_item'             => __('Edit Report', 'textdomain'),
        'view_item'             => __('View Report', 'textdomain'),
        'all_items'             => __('All AGF Report', 'textdomain'),
        'search_items'          => __('Search AGF Report', 'textdomain'),
        'parent_item_colon'     => __('Parent AGF Report:', 'textdomain'),
        'not_found'             => __('No AGF Report found.', 'textdomain'),
        'not_found_in_trash'    => __('No AGF Report found in Trash.', 'textdomain'),
        'featured_image'        => _x('Report Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain'),
        'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain'),
        'archives'              => _x('Report archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain'),
        'insert_into_item'      => _x('Insert into Report', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain'),
        'uploaded_to_this_item' => _x('Uploaded to this Report', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain'),
        'filter_items_list'     => _x('Filter AGF Report list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain'),
        'items_list_navigation' => _x('AGF Report list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain'),
        'items_list'            => _x('AGF Report list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'gravity-form-report'),
        'capability_type'    => 'page',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array('title', 'editor', 'author', "graph_view"),
        // 'taxonomies'         => ['category', 'post_tag' ],
        'show_in rest'       => true
    );
    register_post_type('agfreport', $args);
}

function adding_capabilities()
{
    // adding capabilities to the admin
    get_role('administrator')->add_cap('agf_view_report');

    // if the role exists, add the capabilities to it.
    if (wp_roles()->is_role('group_leader')) {
        get_role('group_leader')->add_cap('agf_view_report');
    }
}


function agf_register_taxonomy()
{
    // $labels = array(
    //     'name'              => _x('Question Category', 'taxonomy general name'),
    //     'singular_name'     => _x('Category', 'taxonomy singular name'),
    //     'search_items'      => __('Search Question Category'),
    //     'all_items'         => __('All Question Category'),
    //     'parent_item'       => __('Parent Question Category'),
    //     'parent_item_colon' => __('Parent Question Category:'),
    //     'edit_item'         => __('Edit Question Category'),
    //     'update_item'       => __('Update Question Category'),
    //     'add_new_item'      => __('Add New Question Category'),
    //     'new_item_name'     => __('New Question Category Name'),
    //     'menu_name'         => __('Question Category'),
    // );
    // $args   = array(
    //     'hierarchical'      => true, // make it hierarchical (like categories)
    //     'labels'            => $labels,
    //     'show_ui'           => true,
    //     'show_admin_column' => true,
    //     'query_var'         => true,
    //     'show_in_rest'        => true,
    //     'rewrite'           => ['slug' => 'question_category'],
    // );
    // register_taxonomy('question_category', array('agfreport'), $args);
}
