<?php
add_shortcode( 'quiz_ui', 'quiz_ui_callback' );
function quiz_ui_callback($atts){
    $custom_atts = shortcode_atts( array(
        'id' => ''
    ) ,$atts);
    ob_start();
    include QZBL_PATH . '/templates/question_quiz_shortcode_template.php';
    return ob_get_clean();
}
?>