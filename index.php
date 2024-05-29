<?php
/**
 * Plugin Name: Questions quiz 
 * Description: This is a plugin which will allow users to participate on quizes.
 * Version: 1.0
 * Author: Md. Sarwar-A-Kawsar
 * Text Domain: qzbl
 * 
 */
if( !defined('ABSPATH') ) exit;
define('QZBL_PATH', plugin_dir_path(__FILE__));
define('QZBL_URL',plugin_dir_url(__FILE__));
// include files 
include QZBL_PATH . '/includes/includes.php';
include ABSPATH . '/wp-includes/pluggable.php';
class QZBN{
    public function __construct(){
        add_action('admin_enqueue_scripts', array($this,'admin_enqueue_callback'));
        add_action('wp_enqueue_scripts', array($this,'wp_enqueue_callback'));
        add_action('admin_enqueue_scripts', array($this,'wp_enqueue_callback'));
        add_action('admin_menu', array($this,'admin_menu'));
        add_filter('the_content', array($this,'qzbl_result_template') );
    }
    function qzbl_result_template( $content ){
        global $post;
        if( is_admin() ) return $content;
        if( $post->post_type != 'results' ) return $content;
        // return 'test_content';
        return do_shortcode( '[result_ui]' );
    }
    public function admin_enqueue_callback(){
        wp_enqueue_style( 'qzbl-css', QZBL_URL . 'assets/css/qzbl-style.css', array(), time() );
        wp_enqueue_style( 'qzbl-select2-css', QZBL_URL . 'assets/css/select2.css' );
        wp_enqueue_script( 'jquery' );
        wp_enqueue_script( 'qzbl-select2-js', QZBL_URL . 'assets/js/select2.js', array('jquery'),time(),true);
    }
    public function wp_enqueue_callback(){
        wp_enqueue_style( 'qzbl-css', QZBL_URL . 'assets/css/qzbl-style.css', array(), time() );
        wp_enqueue_script( 'qzbl-js-main', QZBL_URL . 'assets/js/main.js', array('jquery'),time(),true);
        wp_enqueue_script( 'qzbl-js-loading', QZBL_URL . 'assets/js/loading.js', array('jquery'),time(),true);
        wp_enqueue_script( 'qzbl-js-swal2', QZBL_URL . 'assets/js/swal2.js', array('jquery'),time(),true);
        wp_localize_script( 'qzbl-js-main', 'localize_ajax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'qzbl_url' => QZBL_URL,
            'nonce' => wp_create_nonce( 'submit_quiz_nonce' ),
            'next_question_prevent' => __("You've to select an answer to go to next question",'qzbl'),
            'time_out_text' => __("Time out. You've to start again.",'qzbl'),
        ) );

    }
    function admin_menu(){
        $parent_slug = 'edit.php?post_type=quizs';
        add_menu_page( 'Quiz builder', 'Quiz builder', 'manage_options', $parent_slug, null, 'dashicons-rest-api' , 2 );
        add_submenu_page( $parent_slug, 'Quizes', 'Quizes', 'manage_options', 'edit.php?post_type=quizs', null );
        add_submenu_page( $parent_slug, 'Questions', 'Questions', 'manage_options', 'edit.php?post_type=questions', null );
        add_submenu_page( $parent_slug, 'Results', 'Results', 'manage_options', 'edit.php?post_type=results', null );
        add_submenu_page( $parent_slug, 'Settings', 'Settings', 'manage_options', 'quiz_builder_settings', array($this,'quiz_builder_settings_callback') );
    }
    function quiz_builder_settings_callback(){
        if( isset($_POST['save_settings'])) {
            update_option('qzbl_result_page_id', $_POST['result_page_id_val']);
            echo '<div class="notice notice-success is-dismissible"><p>Settings has been saved.</p></div>';
        }
        $result_page_id = get_option('qzbl_result_page_id');
        include QZBL_PATH . 'templates/admin_menu_template.php';
    }
}
new QZBN();