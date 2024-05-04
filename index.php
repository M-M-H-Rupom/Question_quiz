<?php
/**
 * Plugin Name: Questions 
 * Description: hello
 * Version: 1.0
 * Author: Rupom
 * Text Domain: qzbl
 * 
 */
if( !defined('ABSPATH') ) exit;
define('QZBL_PATH', plugin_dir_path(__FILE__));
define('QZBL_URL',plugin_dir_url(__FILE__));
// include files
include( QZBL_PATH . '/includes/class-post-types.php' );
include(QZBL_PATH . '/includes/class-taxonomies.php');
include( QZBL_PATH . '/includes/class-question-metabox.php' );