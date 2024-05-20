<?php
global $post;
$result_id = $post->ID;
// $atts = shortcode_atts( array(
//     'result_id' => ''
// ), $atts );
// // Get the result ID
// $result_id = $atts['result_id'];
// Get the quiz ID
$quiz_id = get_post_meta( $result_id, 'quiz_id', true);
// Get the quiz title
$quiz_title = get_the_title( $quiz_id );
// Get the questions ID string seperated by comma
$quiz_questions = get_post_meta( $quiz_id, 'selected_questions', true );
// Get the result data
$result_data = get_post_meta( $result_id, 'result_data', true);
// Get correct answer data from the admin's meta data
$correct_ans_data = [];
// Get all the titles of the options
$options_titles = [];
foreach( explode(',',$quiz_questions) as $qtn_id) {
    $options = get_post_meta( $qtn_id, 'options', true );
    $correct_ans = [];
    $this_question_titles = [];
    foreach( $options as $option_key => $option_value ) {
        if( isset($option_value['correct']) ) {
            $correct_ans[] = $option_key;
        }
        $this_question_titles[$option_key] = $option_value['title'];
    }
    $options_titles[$qtn_id] = $this_question_titles;
    $correct_ans_data[$qtn_id] = $correct_ans;
}
$result_ans_data = [];
foreach( $result_data as $a_result ) {
    $result_ans_data[$a_result['qtn_id']] = $a_result['checked_options_val'];
}
?>
<div class="qzbl_result_container">
    <div class="qzbl_result_content">
        <?php $i = 1; foreach( $correct_ans_data as $qtn_id => $answers ) { ?>
        <div class="qzbl_row">
            <div class="qzbl_question_title">
                <p><?php echo $i . ". " . get_the_title( $qtn_id ); ?></p>
            </div>
            <div class="qzbl_answer_container">
                <div class="qzbl_correct_answers">
                    <?php
                    // echo '<pre>'; print_r($answers); echo '</pre>';
                    ?>
                    <p>Correct answers</p>
                    <ul>
                        <?php foreach($answers as $answer) {?>
                        <li><?php echo $options_titles[$qtn_id][$answer]; ?></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="qzbl_user_answers">
                    <?php
                    // echo '<pre>'; print_r($result_ans_data[$qtn_id]); echo '</pre>';
                    ?>
                    <p>Your answers</p>
                    <ul>
                        <?php foreach($result_ans_data[$qtn_id] as $result_answer) {?>
                            <li><?php echo $options_titles[$qtn_id][$result_answer]; ?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="qzbl_question_result" data-answer="<?php echo count(array_diff($result_ans_data[$qtn_id], $answers)) == 0 ? 'right' : 'wrong'; ?>">
                <p><?php echo count(array_diff($result_ans_data[$qtn_id], $answers)) == 0 ? 'Right' : 'Wrong'; ?> answer</p>
            </div>
        </div>
        <?php $i++; } ?>
    </div>
</div>