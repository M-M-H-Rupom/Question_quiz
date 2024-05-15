<?php
add_shortcode('result_ui', 'result_ui_callback');
function result_ui_callback($atts){
    ob_start();
    include QZBL_PATH . '/templates/result_shortcode_template.php';
    return ob_get_clean();
}
?>