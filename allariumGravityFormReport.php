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
include_once( AGFR__PLUGIN_DIR . "deactivate.php" );


// calls the AgfReport class and calls the init function.
$class_agfr = new AgfReport();