<?php
class optionsMetabox {
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_fields' ) );
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
        $row_count = get_post_meta( $post->ID, 'row_count', true);
        ?> 
        <div class="row-container" data-row-count="<?php echo $row_count; ?>">
            <input type="hidden" name="row_count" id="row_count" value="<?php echo $row_count; ?>">
            <?php
            foreach( $rows as $row_key => $row_value ){
                ?>
                    <div class="row">
                        <label for="option_<?php echo $row_key; ?>_title" class="question_title">
                            <span>Question title</span> 
                            <input type="text" name="options[<?php echo $row_key; ?>][title]" id="option_<?php echo $row_key; ?>_title" value="<?php echo $row_value['title']; ?>"> 
                        </label>
                        <label for="option_<?php echo $row_key; ?>_correct">
                            <input type="checkbox" name="options[<?php echo $row_key; ?>][correct]" value="yes" <?php checked($row_value['correct'], 'yes'); ?> id="option_<?php echo $row_key; ?>_correct">
                            <span>Correct Answer</span> 
                        </label>
                        <img src="<?php echo QZBL_URL ."assets/images/close_bt.png" ?>" alt="" class='row_remove_btn'>
                    </div>
            <?php } ?> <img src="" alt="">
        </div>
        <div class="row_add_button">
            <button type='button' class='row_add_btn'> Add more + </button>
        </div>
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
