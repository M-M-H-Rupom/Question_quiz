<?php
/**
 * Plugin Name: Questions 
 * Description: hello
 * Version: 1.0
 * Author: Rupom
 */

class optionsMetabox {
    private $screen = array(
        'questions',
    );
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_fields' ) );
		add_action('admin_enqueue_scripts',array($this,'enqueue_script_callback'));
    }
	public function enqueue_script_callback(){
		wp_enqueue_script( 'main_js', plugin_dir_url( __FILE__ ).'/asset/js/main.js' );
	}
    public function add_meta_boxes() {
        foreach ( $this->screen as $single_screen ) {
            add_meta_box(
                'options',
                'Options',
                array( $this, 'meta_box_callback' ),
                $single_screen,
                'advanced',
                'default'
            );
        }
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
        }
    }
}
new optionsMetabox();
