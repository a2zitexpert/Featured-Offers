<?php
/*
Plugin Name: 	Featured Offers
Plugin URI: 	https://github.com/a2zitexperts/
description: 	Plugin to create Featured Offers List
Version: 		1.6
Author: 		A2zItExpert
Author URI: 	https://github.com/a2zitexperts/
Text Domain:	featured_offers
*/

// No Direct script Allowed
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Directory Paths
define( 'VL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'VL_DIR_PATH', plugin_dir_url( __FILE__ ) );


// Include classes file
require_once( VL_PLUGIN_PATH . 'classes/main_class.php' );

global $vlist;
$vlist = new VL_CLASS_Main();
$Class_View = new VL_CLASS_View();
// register_activation_hook( __FILE__ ,  array( 'VL_CLASS_Main' , 'activate') );
register_deactivation_hook( __FILE__, array( 'VL_CLASS_Main', 'deactivate' ) );
register_deactivation_hook( __FILE__, array( 'VL_CLASS_View', 'deactivate' ) );
?>
