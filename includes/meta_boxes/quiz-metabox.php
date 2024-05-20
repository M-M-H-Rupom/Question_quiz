<?php
class Quizmetabox{
    public function __construct(){
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes_quiz' ) );
        add_action( 'save_post', array( $this, 'save_quiz_fields' ) );
    }
    public function add_meta_boxes_quiz() {
        add_meta_box(
            'select_questions',
            'Select Questions',
            array( $this, 'meta_box_quiz_callback' ),
            'quizs',
            'advanced',
            'default'
        );
    }
    public function meta_box_quiz_callback($post){
        wp_nonce_field( 'quiz_data', 'quiz_nonce' );
        $this->quiz_field_generator($post);
    }
    public function quiz_field_generator($post){
        $get_select_field = get_post_meta( $post->ID,'select_question',true );
        $sel_qtns = get_post_meta( $post->ID,'selected_questions',true );
        $get_duration = get_post_meta( $post->ID,'quiz_duration',true );
        $args = array(
            'post_type' => 'questions',
            'posts_per_page' => -1,
        );
        $get_all_questions = new WP_Query($args);
        ?>
        <table class="form-table">
            <tr>
                <th>Select questions :</th>
                    <td>
                        <input type="hidden" value="<?php echo $sel_qtns; ?>" name="selected_questions" id="selected_questions">
                        <select name="select_question" id="select_question" multiple>
                        <?php
                        while($get_all_questions->have_posts()){
                            $get_all_questions->the_post();
                            $get_title = get_the_title();
                            ?>
                                <option value="<?php echo get_the_ID(); ?>"> <?php echo $get_title ?> </option>
                            <?php
                        }
                        wp_reset_postdata();
                        ?>
                        </select>
                    </td>
            </tr>
            <tr>
                <th>Duration</th>
                <td>
                    <input type="number" name="quiz_duration" id="quiz_duration" value="<?php echo $get_duration ?>">
                    <span>Minutes</span>
                </td>
            </tr>
        </table>
        <?php
    }
    public function save_quiz_fields( $post_id ) {
        // $nonce = $_POST['quiz_nonce'];
        // if ( ! isset( $_POST['quiz_nonce'] ) && !wp_verify_nonce( $nonce, 'quiz_data' ) ){
        //     return $post_id;
        // }
        if( wp_doing_ajax() ) return;
        if(isset($_POST['select_question'])){     // save quiz post type matabox data 
            update_post_meta($post_id,'select_question',$_POST['select_question']);
        }
        if(isset($_POST['selected_questions'])){     // save quiz post type matabox data 
            update_post_meta($post_id,'selected_questions',$_POST['selected_questions']);
        }
        if(isset($_POST['quiz_duration'])){     // save quiz post type matabox data 
            update_post_meta($post_id,'quiz_duration',$_POST['quiz_duration']);
        }
    }
}

new Quizmetabox();