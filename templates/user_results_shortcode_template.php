<?php
if( !is_user_logged_in() ) {
    echo "You are not allowed to access to this page";
    return;
}
$user_id = get_current_user_id();
$results = new WP_Query( array(
    'post_type' => 'results',
    'post_status' => 'publish',
    'posts_per_page' => -1
) );
?>
<div class="qzbl_user_result_container">
<div class="qzbl_quiz_date_link_title">
    <div class="qzbl_quiz_id_title result_item">
        <span> Quiz Title</span>
    </div>
    <div class="qzbl_date_title result_item">
        <span> Date</span>
    </div>
    <div class="qzbl_result_title result_item">
        <span> Result Link</span>
    </div>
</div>    
<?php
if( $results->have_posts() ) {
    while($results->have_posts()) {
        $results->the_post();
        $result_id = get_the_ID();
        if( get_post_meta($result_id, 'result_submitted_user_id', true ) == $user_id ) {
            $quiz_id = get_post_meta($result_id,'quiz_id',true);
            $create_date = get_the_date();
            $result_link = get_permalink( $result_id );
            ?>
            <div class="qzbl_user_results">
                <div class="qzbl_quiz_id result_item">
                    <span> <?php echo get_the_title( $quiz_id); ?></span>
                </div>
                <div class="qzbl_create_date result_item">
                    <span><?php echo $create_date ?></span>
                </div>
                <div class="qzbl_result_link result_item">
                    <span><a style="padding:4px 16px;border-radius:8px;border:1px solid gray;text-decoration:none;" href="<?php echo $result_link ?>">See Result</a></span>
                </div>
            </div>
            <?php
        }
    }
}
wp_reset_query();
?>
</div>
