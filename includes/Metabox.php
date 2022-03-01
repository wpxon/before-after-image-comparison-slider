<?php

namespace BAICS;
 
class Metabox {
 
	public $post_type;
 
	public $context;
 
	public $priority;
 
	public $hook_priority = 10;
 
	public $tab;

	public $tabs;
	
    public $fields;
 
	public $id;
 
	public $label;

	function __construct( $args = null ){
		$this->id 		        = $args['id'] ? : 'wpx_metabox';
		$this->label 			= $args['label'] ? : 'WPX Metabox';
		$this->post_type 		= $args['post_type'] ? : 'post';
		$this->context 			= $args['context'] ? : 'normal';
		$this->priority 		= $args['priority'] ? : 'high';
		$this->hook_priority 	= $args['hook_priority'] ? : 10;
		$this->tab 			    = $args['tab'] ? true : false ;
		$this->tabs 			= $args['tabs'] ? : [] ;
		$this->fields 			= $args['fields'] ? : array();

		self::hooks();
	}

	function enqueue_scripts() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery' );
    }

	public function hooks(){
		add_action( 'add_meta_boxes' , array( $this, 'add_meta_box' ), $this->hook_priority );
		add_action( 'save_post', array( $this, 'save_meta_fields' ), 1, 2 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_head', array( $this, 'scripts' ) );
	}

	public function add_meta_box() {
		if( is_array( $this->post_type ) ){
			foreach ( $this->post_type as $post_type ) {
				add_meta_box( $this->id, $this->label, array( $this, 'meta_fields_callback' ), $post_type, $this->context, $this->priority );
			}
		}
		else{
			add_meta_box( $this->id, $this->label, array( $this, 'meta_fields_callback' ), $this->post_type, $this->context, $this->priority );
		}
	}

	public function meta_fields_callback() {
		global $post;
		
		echo '<input type="hidden" name="mdc_cmb_nonce" id="mdc_cmb_nonce" value="' . 
		wp_create_nonce( plugin_basename( __FILE__ ) ) . '" />';
        if( $this->tab ){              // tab title
            echo '<div class="wpx-tab-menu">';
            foreach ( $this->tabs as $tab ) {  
                ?>
                <a href="<?php echo $tab['id'];?>"><?php echo $tab['title'];?></a> 
                <?php
            } 
            echo '</div>';

            // tab content
            echo '<div class="wpx-tab-body">';
            foreach ( $this->tabs as $tab ) { 
                echo '<div id="'.$tab['id'].'" class="wpx-tab-content">';
                $this->fallback_fields( $tab['fields'] ); 
                echo '</div>';
            }
            echo '</div>';
        }else{
            $this->fallback_fields( $this->fields ); 
        }

	}
	
    public function fallback_fields( $args ){ 
        echo '<table class="wpx-metabox-body">';
        echo '<tbody>'; 
        foreach ( $args as $field ) { 
            if ( $field['type'] == 'text' ) {
                echo $this->field_text( $field );
            }  
        } 
        echo '</tbody>';
        echo '</table>';
    }

	public function save_meta_fields( $post_id, $post ) {
		if (
			! isset( $_POST['mdc_cmb_nonce'] ) ||
			! wp_verify_nonce( $_POST['mdc_cmb_nonce'], plugin_basename( __FILE__ ) ) ||
			! current_user_can( 'edit_post', $post->ID ) ||
			$post->post_type == 'revision'
		) {
			return $post->ID;
		}
        if( $this->tab ){ 
            foreach ( $this->tabs as $tab ){ 
                foreach ( $tab['fields'] as $field ){
                    $key = $field['name'];
                    $meta_values[$key] = $_POST[$key];
                } 
            }
            foreach ( $meta_values as $key => $value ) {
                $value = implode( ',', (array) $value );
                if( get_post_meta( $post->ID, $key, FALSE )) {
                    update_post_meta( $post->ID, $key, $value );
                } else {
                    add_post_meta( $post->ID, $key, $value );
                }
                if( ! $value ) delete_post_meta( $post->ID, $key );
            }
        }else{
            foreach ( $this->fields as $field ){
                $key = $field['name'];
                $meta_values[$key] = $_POST[$key];
            }
    
            foreach ( $meta_values as $key => $value ) {
                $value = implode( ',', (array) $value );
                if( get_post_meta( $post->ID, $key, FALSE )) {
                    update_post_meta( $post->ID, $key, $value );
                } else {
                    add_post_meta( $post->ID, $key, $value );
                }
                if( ! $value ) delete_post_meta( $post->ID, $key );
            }
        }
	}

	public function field_text( $field ){
		global $post; 
        $placeholder = ( isset( $field['placeholder'] ) ) ? $field['placeholder'] : '';
        $field['default'] = ( isset( $field['default'] ) ) ? $field['default'] : '';
        $value = get_post_meta( $post->ID, $field['name'], true ) != '' ? get_post_meta( $post->ID, $field['name'], true ) : $field['default'];
		$readonly  = isset( $field['readonly'] ) && ( $field['readonly'] == true ) ? ' readonly' : '';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? ' disabled' : '';
		$class  =  ( isset( $field['class'] ) ) ? $field['class'] : '';
        ob_start();
        ?>
            <tr class="text-field <?php echo $class;?>" >
                <td><strong><label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label></strong></td>
                <td>
                    <input type="text" id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" <?php echo esc_attr($readonly); ?> <?php echo esc_attr($disabled); ?>>
                    <?php echo $this->field_description( $field ); ?>
                </td>
            </tr>
        <?php
        return ob_get_clean();
	} 
 
	public function field_description( $args ) {
        if ( ! empty( $args['desc'] ) ) { 
        	$desc = sprintf( '<p class="description">%s</p>', $args['desc'] ); 
        } else {
            $desc = '';
        }
        return $desc;
    }

    function scripts() {
        ?>
        <script>
            jQuery(document).ready(function($) {
                //color picker
                $('.wp-color-picker-field').wpColorPicker();

                // media uploader
                $('.mdc-browse').on('click', function (event) {
                    event.preventDefault();

                    var self = $(this);

                    var file_frame = wp.media.frames.file_frame = wp.media({
                        title: self.data('title'),
                        button: {
                            text: self.data('select-text'),
                        },
                        multiple: false
                    });

                    file_frame.on('select', function () {
                        attachment = file_frame.state().get('selection').first().toJSON();

                        self.prev('.mdc-file').val(attachment.url);
                        $('.supports-drag-drop').hide()
                    });

                    file_frame.open();
                });
        });
        </script>

        <style type="text/css">
            /* version 3.8 fix */
            .form-table th { padding: 20px 10px; }
            .mdc-row { border-bottom: 1px solid #ebebeb; padding: 8px 4px; }
            .mdc-row:last-child { border-bottom: 0px;}
            .mdc-row .mdc-label {display: inline-block; vertical-align: top; width: 200px; font-size: 15px; line-height: 24px;}
            .mdc-row .mdc-browse { width: 96px;}
            .mdc-row .mdc-file { width: calc( 100% - 110px ); margin-right: 4px; line-height: 20px;}
            #postbox-container-1 .mdc-meta-field, #postbox-container-1 .mdc-meta-field-text {width: 100%;}
            #postbox-container-2 .mdc-meta-field, #postbox-container-2 .mdc-meta-field-text {width: 74%;}
            #postbox-container-1 .mdc-meta-field-text.mdc-file { width: calc(100% - 101px) }
            #postbox-container-2 .mdc-meta-field-text.mdc-file { width: calc(100% - 306px) }
            #wpbody-content .metabox-holder { padding-top: 5px; }
        </style>
        <?php
    }
} 
