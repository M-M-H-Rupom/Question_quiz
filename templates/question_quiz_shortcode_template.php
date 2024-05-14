<?php
$quiz_post_id = $custom_atts['id'];
$get_post = get_post($quiz_id);
$get_selected_questions = explode(',',get_post_meta( $quiz_post_id, 'selected_questions', true));
?>
<div class="qz_container">
<div class="qz_head">
    <div class="qz_quiz_title_logo">
        <span> <?php echo get_the_title($quiz_post_id)?> </span>
    </div>
    <div class="qz_time_pause_results">
        <div class="qz_time logo_text">
            <img src="<?php echo QZBL_URL . 'assets/images/carbon_time.png' ?>" alt="">
            <span> 40:00 / <span> 40 </span> </span>
        </div>
        <div class="qz_pause logo_text">
            <img src="<?php echo QZBL_URL . 'assets/images/carbon_pause-outline.png' ?> " alt="">
            <span> Pause </span>
        </div>
        <div class="qz_results logo_text">
            <img src="<?php echo QZBL_URL . 'assets/images/icon-park-outline_list.png' ?> " alt="">
            <span> Results </span>
        </div>
    </div>
</div>
<div class="qz_content_main">
    <div class="qz_content qtn_active" data-step="1" data-qtn-id="10">
    <?php 
    foreach($get_selected_questions as $single_question){
        $question_title = get_the_title($single_question);
        ?>
        <div class="qz_content_childs">
            <div class="qz_content_title">
                <span> 
                    <?php echo $question_title ?>
                </span>
            </div>
            <!-- questions meta data -->
            <div class="qz_content_field"> 
                <?php 
                $get_question_meta = get_post_meta( $single_question, 'options', true );
                foreach($get_question_meta as $single_meta){
                    ?> 
                    <div class="qz_field_text">
                        <label class="field_checkbox ">
                            <input type="checkbox" name="" id="">
                        </label>
                        <div class="field_option_text">
                            <span><?php echo $single_meta['title']; ?> </span>
                        </div>
                    </div>
                    <?php
                }
                ?>       
            </div>
        </div>
    <?php } ?>
        <div class="qz_content_buttons">
            <button class="qz_btn">Previous </button>
            <button class="qz_btn">Next </button>
        </div>
    </div>
</div>
</div>