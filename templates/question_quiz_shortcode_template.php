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
        <!-- <div class="qz_pause logo_text">
            <img src="<?php echo QZBL_URL . 'assets/images/carbon_pause-outline.png' ?> " alt="">
            <span> Pause </span>
        </div> -->
        <div class="qz_results logo_text">
            <img src="<?php echo QZBL_URL . 'assets/images/icon-park-outline_list.png' ?> " alt="">
            <span> Results </span>
        </div>
    </div>
</div>
<div class="qz_progress_bar">
    <div class="qz_progress"></div>
</div>
<div class="qz_content_main">
    <div class="qz_content qtn_active" data-step="1" data-qtn-id="10">
    <?php 
    $question_number = 1;
    foreach($get_selected_questions as $single_question){
        $question_title = get_the_title($single_question);
        ?>
        <div class="qz_content_childs" data-step="<?php echo $question_number; ?>" data-qtn-id="<?php echo $single_question; ?>">
            <div class="qz_content_title">
                <span> 
                   <span> <?php echo $question_number.". " ; $question_number++ ?> </span> <br> <?php echo $question_title ?>
                </span>
            </div>
            <!-- questions meta data -->
            <div class="qz_content_field"> 
                <?php 
                $get_question_meta = get_post_meta( $single_question, 'options', true );
                foreach($get_question_meta as $option_index => $single_meta){
                    ?> 
                    <div class="qz_field_text">
                        <label class="field_checkbox ">
                            <input type="checkbox" name="write_question" value="<?php echo $option_index; ?>" id="" class='qz_write_question' >
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
    </div>
    <div class="qz_content_buttons">
        <button class="qz_btn qz_btn_previous">Previous </button>
        <button class="qz_btn qz_btn_next">Next </button>
    </div>
</div>
</div>