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
    }
    
    public function meta_box_callback( $post ) {
        wp_nonce_field( 'options_data', 'options_nonce' );
        $this->field_generator( $post );
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
            <div class="option_add_button">
                <button class='option_add_btn'> Add more + </button>
            </div>
        <pre>
        <?php 
        $options = get_post_meta($post->ID, 'question_options', true );
    }

    public function save_fields( $post_id ) {
        $nonce = $_POST['options_nonce'];
        if ( ! isset( $_POST['options_nonce'] ) && !wp_verify_nonce( $nonce, 'options_data' ) ){
            return $post_id;
        }
        if ( isset( $_POST['options' ] ) ) {
            update_post_meta( $post_id, 'question_options', $_POST['options'] );
        }
    }
}
new optionsMetabox();
