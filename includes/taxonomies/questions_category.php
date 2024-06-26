<?php
function cptui_register_questions_taxonomy() {
    $labels_questions = [
        "name" => esc_html__( "Question categories", "qzbl" ),
        "singular_name" => esc_html__( "Question category", "qzbl" ),
    ];
    $args_questions = [
        "label" => esc_html__( "Question categories", "qzbl" ),
        "labels" => $labels_questions,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => [ 'slug' => 'questions_category', 'with_front' => true, ],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "questions_category",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "rest_namespace" => "wp/v2",
        "show_in_quick_edit" => false,
        "sort" => false,
        "show_in_graphql" => false,
    ];
    register_taxonomy( "questions_category", [ "questions" ], $args_questions );
}
add_action( 'init', 'cptui_register_questions_taxonomy' );