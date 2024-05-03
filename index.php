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

    private $meta_fields = array(
        array(
            'label' => 'Option title',
            'id' => 'options',
            'type' => 'text',
        ),
        array(
            'label' => 'Correct answer',
            'id' => 'options',
            'type' => 'radio',
            'options' => array(
                'Correct answer',
            ),
        ),
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
		// $meta_value = get_post_meta( $post->ID, 'options', true );
		// $title_meta = $meta_value['title'];
		// $correct_meta = $meta_value['correct'];
		// print_r($meta_value);
        $output = '';
        foreach ( $this->meta_fields as $meta_field ) {
            $label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
            
            switch ( $meta_field['type'] ) {
                case 'radio':
                    $input = '';
                    foreach ( $meta_field['options'] as $key => $value ) {
                        $selected = ($correct_meta == $value) ? 'checked' : '';
                        $input .= sprintf(
                            '<input %s id="%s" name="%s" type="radio" value="%s">',
                            $selected,
                            $meta_field['id'],
                            'options[][correct]',
                            $value
                        );
                    }
                    break;
                default:
                    $input = sprintf(
                        '<input id="%s" name="%s" type="%s" value="%s">',
                        $meta_field['id'],
                        'options[][title]',
                        $meta_field['type'],
                        $title_meta
                    );
            }
            $output .=  $label ." ". $input . "<br>";
        }
        echo $output ;
    }

    public function save_fields( $post_id ) {
        if ( ! isset( $_POST['options_nonce'] ) )
            return $post_id;
        $nonce = $_POST['options_nonce'];
        if ( !wp_verify_nonce( $nonce, 'options_data' ) )
            return $post_id;
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return $post_id;
        foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
                
                 update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
            
            }
        }
    }
}
new optionsMetabox();
