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
        $rows = get_post_meta( $post->ID, 'options', true);
        echo '<pre>';
        print_r($rows);
        echo '</pre>';
        $row_count = get_post_meta( $post->ID, 'row_count', true);
        foreach( $rows as $row_key => $row_value ){
            ?>
            <div class="row-container" data-row-count="<?php echo $row_count; ?>">
                <div class="row">
                    <label for="options">
                        <span>Question title</span> 
                        <input type="text" name="options[<?php echo $row_key; ?>][title]" id="options" value="<?php echo $row_value['title']; ?>"> 
                    </label>
                    <label for="option_<?php echo $row_key; ?>_correct">
                        <input type="radio" name="options[<?php echo $row_key; ?>][correct]" value="yes" <?php checked($row_value['correct'], 'yes'); ?> id="option_<?php echo $row_key; ?>_correct"> 
                        <span>Correct Answer</span> 
                    </label>
                    <button type='button' class='row_remove_btn'> Remove </button>
                </div>
            <?php } ?>
            <input type="hidden" name="row_count" id="row_count" >
            </div>
            <button type='button' class='row_add_btn'> Add more + </button>
            <?php 
    }

    public function save_fields( $post_id ) {
        $nonce = $_POST['options_nonce'];
        if ( ! isset( $_POST['options_nonce'] ) && !wp_verify_nonce( $nonce, 'options_data' ) ){
            return $post_id;
        }
        if ( isset( $_POST['options' ] ) ) {
            update_post_meta( $post_id, 'options', $_POST['options'] );
        }
        if ( isset($_POST['row_count']) ) {
            update_post_meta($post_id, 'row_count', $_POST['row_count']);
        }
    }
}
new optionsMetabox();
