<?php
add_shortcode('user_results','user_results_callback');
function user_results_callback(){
    ob_start();
    include QZBL_PATH . 'templates/user_results_shortcode_template.php';
    return ob_get_clean();
}