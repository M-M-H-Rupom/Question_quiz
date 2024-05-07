<?php
function  cptui_register_quiz_taxonomy(){
    $labels_quiz = [
        "name" => esc_html__( "Quiz categories", "qzbl" ),
        "singular_name" => esc_html__( "Quiz category", "qzbl" ),
    ];
    $args_quiz = [
        "label" => esc_html__( "Quiz categories", "qzbl" ),
        "labels" => $labels_quiz,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => [ 'slug' => 'quiz_category', 'with_front' => true, ],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "quiz_category",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "rest_namespace" => "wp/v2",
        "show_in_quick_edit" => false,
        "sort" => false,
        "show_in_graphql" => false,
    ];
    register_taxonomy( "quiz_category", [ "quizs" ], $args_quiz );
}
add_action( 'init','cptui_register_quiz_taxonomy');