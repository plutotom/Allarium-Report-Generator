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

if ( ! defined ( 'ABSPATH')) exit; // Exit if accessed directly


define( 'AGFR__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
include_once(AGFR__PLUGIN_DIR . "class.agfr.php");
// include_once( AGFR__PLUGIN_DIR . "meta_box_graph.php" );
include_once( AGFR__PLUGIN_DIR . "deactivate.php" );


// ###### enqueue scripts ######
function enqueue_multi_select_scripts() {
    print_r("enqueueing scripts");
    wp_enqueue_script('multiselect', 'https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js');
    wp_enqueue_style('multiselect-css', 'https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/css/multi-select.css');
    wp_enqueue_script(
        'msjs',
        plugin_dir_url(__FILE__).'js/multi_select_js.js');
}


add_action( 'wp_enqueue_scripts', 'enqueue_multi_select_scripts' );
// calls the AgfReport class and calls the init function.
$class_agfr = new AgfReport();
// below was only a test to see if the class was working.
// add_shortcode( 'agfReportGraph', array( 'AgfReport', 'Agf_report_function' ) );

//call the 'add_menu_page' function with 'admin_menu' action hook
// add_action( 'admin_menu', array( $this, 'wpdocs_add_menu_page' ), 99 );
 


// /**
//  * Add page to admin menu
//  */
// public function wpdocs_add_menu_page() {
//     add_menu_page(
//         esc_html__( 'WooCommerce B2B Sales Agents', 'woocommerce-b2b-sales-agents' ),
//         esc_html__( 'WooCommerce B2B Sales Agents', 'woocommerce-b2b-sales-agents'),
//         'manage_woocommerce',
//         'wcb2bsa-commissions',
//         null,
//         'dashicons-businessman',
//         55.5
//     );
//     add_submenu_page(
//         'wcb2bsa-commissions',
//         esc_html__( 'Commissions', 'woocommerce-b2b-sales-agents' ),
//         esc_html__( 'Commissions', 'woocommerce-b2b-sales-agents' ),
//         'manage_woocommerce',
//         'wcb2bsa-commissions',
//         array( $this, 'wpdocs_add_menu_page_callback' )
//     );
// }
 
// /**
//  * Add page to admin menu callback
//  */
// public function wpdocs_add_menu_page_callback() {
//     include WCB2BSA_ABSPATH . 'includes/views/html-admin--page-commissions.php';
// }