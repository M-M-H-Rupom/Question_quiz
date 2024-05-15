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
        add_filter('the_content', array($this,'qzbl_result_template') );
    }
    function qzbl_result_template( $content ){
        global $post;
        if( $post->post_type != 'results' ) return;
        // return 'test_content';
        return do_shortcode( '[result_ui result_id="'.$post->ID.'"]' );
    }
    public function admin_enqueue_callback(){
        wp_enqueue_style( 'qzbl-css', QZBL_URL . 'assets/css/qzbl-style.css' );
        wp_enqueue_style( 'qzbl-select2-css', QZBL_URL . 'assets/css/select2.css' );
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'qzbl-select2-js', QZBL_URL . 'assets/js/select2.js', array('jquery'),time(),true);
        wp_enqueue_script( 'qzbl-js', QZBL_URL . 'assets/js/main.js', array('jquery'),time(),true);
    }
    public function wp_enqueue_callback(){
        wp_enqueue_style( 'qzbl-css', QZBL_URL . 'assets/css/qzbl-style.css' );
        wp_enqueue_script( 'qzbl-js-main', QZBL_URL . 'assets/js/main.js', array('jquery'),time(),true);
        wp_enqueue_script( 'qzbl-js-swal2', QZBL_URL . 'assets/js/swal2.js', array('jquery'),time(),true);
        wp_localize_script( 'qzbl-js-main', 'localize_ajax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce( 'submit_quiz_nonce' )
        ) );

    }
}
new QZBN();