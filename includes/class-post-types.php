<?php
class QZBL_post_types{
    function __construct(){
        add_action( 'init', [$this,'qzbl_register_my_cpts_questions'] );
        add_action( 'init', [$this,'qzbl_register_my_cpts_quizs'] );
    }
    //register post type questions 
    function qzbl_register_my_cpts_questions() {
        $labels = [
            "name" => esc_html__( "Questions", "qzbl" ),
            "singular_name" => esc_html__( "Question", "qzbl" ),
        ];
    
        $args = [
            "label" => esc_html__( "Questions", "qzbl" ),
            "labels" => $labels,
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "rest_namespace" => "wp/v2",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "page",
            "map_meta_cap" => true,
            "hierarchical" => true,
            "can_export" => false,
            "rewrite" => [ "slug" => "questions", "with_front" => true ],
            "query_var" => true,
            "supports" => [ "title", "editor", "thumbnail", "page-attributes" ],
            "show_in_graphql" => false,
        ];
    
        register_post_type( "questions", $args );
    }
    // register post type quiz
    function qzbl_register_my_cpts_quizs() {
        $labels = [
            "name" => esc_html__( "Quizs", "qzbl" ),
            "singular_name" => esc_html__( "Quiz", "qzbl" ),
        ];
    
        $args = [
            "label" => esc_html__( "Quizs", "qzbl" ),
            "labels" => $labels,
            "description" => "",
            "public" => true,
            "publicly_queryable" => true,
            "show_ui" => true,
            "show_in_rest" => true,
            "rest_base" => "",
            "rest_controller_class" => "WP_REST_Posts_Controller",
            "rest_namespace" => "wp/v2",
            "has_archive" => false,
            "show_in_menu" => true,
            "show_in_nav_menus" => true,
            "delete_with_user" => false,
            "exclude_from_search" => false,
            "capability_type" => "page",
            "map_meta_cap" => true,
            "hierarchical" => true,
            "can_export" => false,
            "rewrite" => [ "slug" => "quiz", "with_front" => true ],
            "query_var" => true,
            "supports" => [ "title", "editor", "thumbnail", "page-attributes" ],
            "show_in_graphql" => false,
        ];
    
        register_post_type( "quizs", $args );
    }
}
new QZBL_post_types();