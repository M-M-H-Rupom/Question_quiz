<?php
function qzbl_register_my_cpts_questions() {
    $labels = [
        "name" => esc_html__( "Questions", "qzbl" ),
        "singular_name" => esc_html__( "Question", "qzbl" ),
        "add_new_item" => esc_html__( "Add New Question", "qzbl" ),
        "add_new" => esc_html__( "Add New Question", "qzbl" ),
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
        "show_in_menu" => false,
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
add_action( 'init','qzbl_register_my_cpts_questions' );