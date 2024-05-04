<?php
class optionsMetabox {
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_fields' ) );
		add_action('admin_enqueue_scripts',array($this,'enqueue_script_callback'));
    }
	public function enqueue_script_callback(){
		wp_enqueue_script( 'main_js', plugin_dir_url( __FILE__ ).'/asset/js/main.js',array('jquery'),time(), true );
	}
    public function add_meta_boxes() {
            add_meta_box(
                'options',
                'Options',
                array( $this, 'meta_box_callback' ),
                'questions',
                'advanced',
                'default'
            );
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
        wp_nonce_field( 'options_data', 'options_nonce' );
        $this->quiz_field_generator($post);
    }
    public function meta_box_callback( $post ) {
        wp_nonce_field( 'options_data', 'options_nonce' );
        $this->field_generator( $post );
    }
    public function quiz_field_generator($post){
        $get_select_field = get_post_meta( $post->ID,'select_question',true );
        $args = array(
            'post_type' => 'questions',
            'posts_per_page' => -1,
        );
        $get_all_questions = new WP_Query($args);
        echo '<select name="select_question" id="select_question">';
        while($get_all_questions->have_posts()){
            $get_all_questions->the_post();
            $get_title = get_the_title();
            $selected = '';
            if($get_select_field == $get_title){
                $selected = 'selected';
            }
            ?>
            <option <?php echo $selected ?> value="<?php echo get_the_title() ?>"> <?php echo get_the_title() ?> </option>
            <?php
        }
        wp_reset_postdata();
        echo '</select>';
    }
    public function field_generator( $post ) {
		?>
        <div class="options_container">
            <div class="options_row">
                <label for="">
                    <span>Option Title</span> 
                    <input type="text" name="options[0]['title']" id="options"> 
                    <input type="radio" name="options[0]['correct']"  id="options"> Correct Answer 
                </label> 
                <img src="<?php echo plugin_dir_url( __FILE__ ).'/asset/images/close _1.png' ?>" alt="" style="width:20px; height:20px;">
            </div>
            <div class="options_row">
                <label for="">
                    <span>Option Title</span> 
                    <input type="text" name="options[1]['title']" id="options"> 
                    <input type="radio" name="options[1]['correct']"  id="options"> Correct Answer 
                </label> 
                <img src="<?php echo plugin_dir_url( __FILE__ ).'/asset/images/close _1.png' ?>" alt="" style="width:20px; height:20px;">
            </div>
        
            <div class="options_row">
                <label for="">
                    <span>Option Title</span> 
                    <input type="text" name="options[2]['title']" id="options"> 
                    <input type="radio" name="options[2]['correct']"  id="options"> Correct Answer 
                </label> 
                <img src="<?php echo plugin_dir_url( __FILE__ ).'/asset/images/close _1.png' ?>" alt="" style="width:20px; height:20px;">
            </div>
        
            
            <div class="options_row">
                <label for="">
                    <span>Option Title</span> 
                    <input type="text" name="options[3]['title']" id="options"> 
                    <input type="radio" name="options[3]['correct']"  id="options"> Correct Answer 
                </label> 
                <img src="<?php echo plugin_dir_url( __FILE__ ).'/asset/images/close _1.png' ?>" alt="" style="width:20px; height:20px;">
            </div>
        
        </div>   
        <pre>
        <?php 
        $options = get_post_meta($post->ID, 'question_options', true );
        print_r($options);

        echo '</pre>';
    }

    public function save_fields( $post_id ) {
        if ( ! isset( $_POST['options_nonce'] ) )
            return $post_id;
        $nonce = $_POST['options_nonce'];
        if ( !wp_verify_nonce( $nonce, 'options_data' ) )
            return $post_id;
        if ( isset( $_POST['options' ] ) ) {
            update_post_meta( $post_id, 'question_options', $_POST['options'] );
        }elseif(isset($_POST['select_question'])){     // save quiz post type matabox data 
            update_post_meta($post_id,'select_question',$_POST['select_question']);
        }
    }
}
new optionsMetabox();
