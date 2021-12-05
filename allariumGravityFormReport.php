<?php

/*
Plugin Name: Form Report Generator - Allarium
Plugin URI: https://github.com/plutotom/Allarium-Gravity-Forms-Validation
Description: Creates exportable reports for suers after taking survey.
Version: 1.0
Author: Allarium
Author URI: https://www.allarium.com/
License: GPLv2 or later
Text Domain: Gravity Forms Validation
*/

if (!defined('ABSPATH')) exit; // Exit if accessed directly

define('AGFR__PLUGIN_DIR', plugin_dir_path(__FILE__));

// include_once(AGFR__PLUGIN_DIR . "class.agfr.php");
include_once(AGFR__PLUGIN_DIR . "includes/deactivate.php");
include(AGFR__PLUGIN_DIR . "includes/init.php");
include(AGFR__PLUGIN_DIR . "includes/admin/settings_menu.php");
include(AGFR__PLUGIN_DIR . "includes/metaboxes/graph_metabox.php");
include(AGFR__PLUGIN_DIR . "includes/metaboxes/save_functions/save_reporting_metabox.php");
include(AGFR__PLUGIN_DIR . "includes/metaboxes/list_forms_metabox.php");
include(AGFR__PLUGIN_DIR . "includes/shortcodes/shortcode_table.php");
// Hooks
// register_activation_hook(__FILE__, 'agf_init_report');
register_deactivation_hook(__FILE__, 'agfr_deactivate');
add_action('init', 'agf_init_report');
add_action('init', 'agf_register_taxonomy');
add_action('admin_menu', 'agf_register_settings');

//Hooks for metaboxes
add_action('add_meta_boxes', 'agf_register_reporting_metabox');
add_action('save_post', 'agf_save_reporting_metabox', 10, 2);
add_action('add_meta_boxes', 'agf_register_list_forms_metabox');
// TODO make save function for agf_register_list_forms_metabox
// TODO make agf_register_list_forms_metabox a multi select metabox


// ShortCode
add_shortcode('agfTable', 'agf_shortcode_table_func');
// add_shortcode('agfGraph', 'Agf_short_code_graph_func');




// enqueue scripts and styles
// TODO enqueue scripts for shortcode frontend table.



// // ###### enqueue scripts ######
// function enqueue_multi_select_scripts()
// {
//     print_r("enqueueing scripts");
//     wp_enqueue_script('multiselect', 'https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js');
//     wp_enqueue_style('multiselect-css', 'https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.css');
//     wp_enqueue_script(
//         'msjs',
//         plugin_dir_url(__FILE__) . 'js/multi_select_js.js'
//     );
// }


// add_action('wp_enqueue_scripts', 'enqueue_multi_select_scripts');
// // calls the AgfReport class and calls the init function.
// $class_agfr = new AgfReport();
