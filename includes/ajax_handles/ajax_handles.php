<?php
add_action( 'wp_ajax_quiz_data','ajax_quiz_data_callback' );
add_action( 'wp_ajax_nopriv_quiz_data','ajax_quiz_data_callback' );
function ajax_quiz_data_callback(){
    if( wp_verify_nonce( $_POST['nonce'], 'submit_quiz_nonce' ) ) {
        wp_send_json_error( 'Unauthorized request.', 401 );
    }
    if( !isset($_POST['quiz_data']) || !isset($_POST['quiz_id']) ) {
        wp_send_json_error( 'Invalid request data', 400 );
    }
    $data = $_POST['quiz_data'];
    $quiz_id = $_POST['quiz_id'];
    $result_id = wp_insert_post( array(
        'post_type' => 'results',
        'post_status' => 'publish',
        'post_title' => "Something"
    ) );
    update_post_meta( $result_id, 'result_data', $data );
    update_post_meta( $result_id, 'quiz_id', $quiz_id );
    if( is_user_logged_in() ) {
        update_post_meta( $result_id, 'result_submitted_user_id', get_current_user_id() );
    }
    wp_send_json_success($result_id);
}