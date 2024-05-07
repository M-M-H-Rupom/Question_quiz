<?php
/**
 * Plugin Name: Questions quiz 
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
include QZBL_PATH . '/includes/includes.php';

class QZBN{
    public function __construct(){
        add_action('admin_enqueue_scripts', array($this,'admin_enqueue_callback'));
        add_action('wp_enqueue_scripts', array($this,'wp_enqueue_callback'));
    }
    public function admin_enqueue_callback(){
        wp_enqueue_style( 'qzbl-css', QZBL_URL . 'assets/css/qzbl-style.css' );
    }
    public function wp_enqueue_callback(){
        wp_enqueue_style( 'qzbl-css', QZBL_URL . 'assets/css/qzbl-style.css' );
    }
}
new QZBN();