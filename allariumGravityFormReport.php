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
// Include Meta Boxes
include(AGFR__PLUGIN_DIR . "includes/metaboxes/graph_metabox.php");
include(AGFR__PLUGIN_DIR . "includes/metaboxes/save_functions/agf_save_metabox.php");
include(AGFR__PLUGIN_DIR . "includes/metaboxes/list_forms_metabox.php");
include(AGFR__PLUGIN_DIR . "includes/metaboxes/short_code_hint_metabox.php");
// include short code 
// include(AGFR__PLUGIN_DIR . "includes/short_codes/short_code_table.php");
include(AGFR__PLUGIN_DIR . "includes/short_codes/agf_allarium_score.php");
include(AGFR__PLUGIN_DIR . "includes/short_codes/agf_short_code_pdf_print.php");
include(AGFR__PLUGIN_DIR . "includes/short_codes/agf_average_score_code.php");

// include helper 
include(AGFR__PLUGIN_DIR . "includes/helper_class/helper_class.php");
// include enqueue scripts file
include(AGFR__PLUGIN_DIR . "includes/admin/enqueue_scripts.php");
include(AGFR__PLUGIN_DIR . "includes/enqueue_frontend/agf_pdf_print_script.php");
//include enqueue styles file
include(AGFR__PLUGIN_DIR . "includes/admin/enqueue_styles.php");
// include ajax processes
include(AGFR__PLUGIN_DIR . "process/process_form_metabox_ajax.php");
include(AGFR__PLUGIN_DIR . "process/process_scoring_categories.php");
include(AGFR__PLUGIN_DIR . "process/agf_process_pdf_print.php");
//include custom actions
include_once(AGFR__PLUGIN_DIR . "includes/custom_actions/agf_gform_after_submission.php");

require_once __DIR__ . '/vendor/autoload.php';

// Hooks
register_deactivation_hook(__FILE__, 'agf_deactivate');
add_action('init', 'agf_init');
// add_action('init', 'agf_register_taxonomy');
// add_action('init', 'Agf_Helper_Class');
// add_action( 'init', array( 'Agf_Helper_Class', 'init' ) );

// add_action('admin_menu', 'agf_register_settings');

//Hooks for metaboxes
// add_action('add_meta_boxes', 'agf_register_reporting_metabox');
add_action('add_meta_boxes', 'agf_register_list_forms_metabox');
add_action('post_submitbox_misc_actions', 'agf_render_short_code_hint');
add_action('save_post', 'agf_save_metabox', 10, 2);


// ajax hooks
add_action('wp_ajax_add_question_category', 'agf_add_question_category_process');
add_action('wp_ajax_agf_update_post_meta', 'agf_update_post_meta_process');
add_action('wp_ajax_agf_score_entries', 'agf_score_entries');


// enqueue scripts and styles
add_action('admin_enqueue_scripts', 'agf_enqueue_styles');
add_action('admin_enqueue_scripts', 'agf_get_post_data_list_questions_metabox_script');
//* Enqueue scripts for html to pdf print.
add_action('wp_footer', 'agf_enqueue_frontend_scripts'); 

// Short_Code
add_shortcode('allarium_score', 'agf_short_code_score');
add_shortcode('allarium_score_print', 'agf_short_code_pdf_print');
add_shortcode('allarium_score_average', 'agf_average_score_short_code');