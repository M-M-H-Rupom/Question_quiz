<?php
function qzbl_register_my_cpts_results() {
    $labels = [
        "name" => esc_html__( "Results", "qzbl" ),
        "singular_name" => esc_html__( "Result", "qzbl" ),
        "add_new_item" => esc_html__( "Add New Result", "qzbl" ),
        "add_new" => esc_html__( "Add New Result", "qzbl" ),
    ];

    $args = [
        "label" => esc_html__( "Results", "qzbl" ),
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
        "rewrite" => [ "slug" => "result", "with_front" => true ],
        "query_var" => true,
        "supports" => [ "title", "editor", "thumbnail", "page-attributes" ],
        "show_in_graphql" => false,
    ];

    register_post_type( "results", $args );
}
add_action( 'init', 'qzbl_register_my_cpts_results');