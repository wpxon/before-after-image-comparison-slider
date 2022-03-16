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
                <a href="<?php echo $tab['id'];?>">
                    <?php if($tab['icon']): ?>
                        <span class="dashicons <?php echo $tab['icon'];?>"></span>
                    <?php endif; ?>
                <?php echo $tab['title'];?></a> 
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
            if ( $field['type'] == 'textarea' ) {
                echo $this->field_textarea( $field );
            }  
            if ( $field['type'] == 'radio' ) {
                echo $this->field_radio( $field );
            }  
            if ( $field['type'] == 'select' ) {
                echo $this->field_select( $field );
            }  
            if ( $field['type'] == 'checkbox' ) {
                echo $this->field_checkbox( $field );
            }  
            if ( $field['type'] == 'file' ) {
                echo $this->field_file( $field );
            }  
            if ( $field['type'] == 'colorpicker' ) {
                echo $this->field_colorpicker( $field );
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
		$require  = isset( $field['require'] ) && ( $field['require'] == true ) ? $field['require'] : '';
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'wpx-meta-field';
        ob_start();
        ?>
            <tr class="text-field <?php echo $class;?> <?php echo $require;?>" >
                <td><strong><label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label></strong></td>
                <td>
                    <input type="text" id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" <?php echo esc_attr($readonly); ?> <?php echo esc_attr($disabled); ?>>
                    <?php echo $this->field_description( $field ); ?>
                </td>
            </tr>
        <?php
        return ob_get_clean();
	} 

	public function field_textarea( $field ){
		global $post; 
        $placeholder = ( isset( $field['placeholder'] ) ) ? $field['placeholder'] : '';
        $field['default'] = ( isset( $field['default'] ) ) ? $field['default'] : '';
        $value = get_post_meta( $post->ID, $field['name'], true ) != '' ? get_post_meta( $post->ID, $field['name'], true ) : $field['default'];
		$readonly  = isset( $field['readonly'] ) && ( $field['readonly'] == true ) ? ' readonly' : '';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? ' disabled' : '';
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'wpx-meta-field';
        $columns = ( isset( $field['columns'] ) ) ? $field['columns'] : '';
        $rows = ( isset( $field['rows'] ) ) ? $field['rows'] : '';
        ob_start();
        ?>
            <tr class="text-field <?php echo $class;?>" >
                <td><strong><label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label></strong></td>
                <td>
                    <textarea rows="<?php echo $rows; ?>" cols="<?php echo $columns; ?>" class="<?php echo $class; ?>" id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>" placeholder="<?php echo esc_attr($placeholder); ?>" <?php echo esc_attr($readonly); ?> <?php echo esc_attr($disabled); ?>><?php echo esc_attr($value); ?></textarea>
                    <?php echo $this->field_description( $field ); ?>
                </td>
            </tr>
        <?php
        return ob_get_clean();
	} 

	public function field_radio( $field ){
		global $post; 
        $value = get_post_meta( $post->ID, $field['name'], true ) != '' ? get_post_meta( $post->ID, $field['name'], true ) : $field['default']; 
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'wpx-meta-field';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";
        ob_start();
        ?>
            <tr class="text-field <?php echo $class;?>" >
                <td><strong><label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label></strong></td>
                <td>
                    <?php foreach ( $field['options'] as $key => $label ) { ?>
                        <label for="<?php echo $field['name']; ?>[<?php echo $key; ?>]">
                            <input type="radio" class="radio <?php echo $class; ?>" id="<?php echo $field['name']; ?>[<?php echo $key; ?>]" name="<?php echo $field['name']; ?>" value="<?php echo $key; ?>" <?php echo checked( $value, $key, false ); ?><?php echo $disabled; ?>><?php echo $label; ?>
                        </label>  
                    <?php } ?>  
                    <?php echo $this->field_description( $field ); ?>
                </td>
            </tr>
        <?php
	} 

	public function field_select( $field ){
		global $post; 
        $value = get_post_meta( $post->ID, $field['name'], true ) != '' ? get_post_meta( $post->ID, $field['name'], true ) : $field['default'];  
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'wpx-meta-field';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";
        $multiple  = isset( $field['multiple'] ) && ( $field['multiple'] == true ) ? " multiple" : "";
        $name 	   = isset( $field['multiple'] ) && ( $field['multiple'] == true ) ? $field['name'] . '[]' : $field['name'];
        ob_start();
        ?>
            <tr class="text-field <?php echo $class;?>" >
                <td><strong><label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label></strong></td>
                <td>
                    <select class="<?php echo $class; ?>" name="<?php echo $name; ?>" id="<?php echo $name; ?>" <?php echo $multiple; ?> <?php echo $disabled; ?>>
                        <?php foreach ( $field['options'] as $key => $label ) { ?>
                            <?php if( $multiple == '' ): // single select ?>
                                <option value="<?php echo $key; ?>" <?php echo selected( $value, $key, false ); ?>><?php echo $label; ?></option>  
                            <?php else: // multiple select ?>
                                <?php 
                                    $values = explode( ',', $value );
                                    $selected = in_array( $key, $values ) && $key != '' ? ' selected' : ''; 
                                ?> 
                                <option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $label; ?></option> 
                            <?php endif; ?>
                        <?php } ?>
                    </select>
                    <?php echo $this->field_description( $field ); ?>
                </td>
            </tr>
        <?php
	}
 
	public function field_checkbox( $field ){
		global $post; 
		$field['default'] = ( isset( $field['default'] ) ) ? $field['default'] : '';
        $value = get_post_meta( $post->ID, $field['name'], true ) != '' ? get_post_meta( $post->ID, $field['name'], true ) : $field['default']; 
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'wpx-meta-field';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";
        ob_start();
        ?>
            <tr class="text-field <?php echo $class;?>" >
                <td><strong><label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label></strong></td>
                <td> 
                    <input type="checkbox" class="<?php echo $class; ?>" id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>" value="on" <?php echo checked( $value, 'on', false ); ?> <?php echo $disabled; ?> >
                    <?php echo $this->field_description( $field ); ?>
                </td>
            </tr>
        <?php 
	}
 
	public function field_colorpicker( $field ){
		global $post; 
        $placeholder = ( isset( $field['placeholder'] ) ) ? $field['placeholder'] : '';
        $field['default'] = ( isset( $field['default'] ) ) ? $field['default'] : '';
        $value = get_post_meta( $post->ID, $field['name'], true ) != '' ? get_post_meta( $post->ID, $field['name'], true ) : $field['default'];
		$readonly  = isset( $field['readonly'] ) && ( $field['readonly'] == true ) ? ' readonly' : '';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? ' disabled' : '';
		$require  = isset( $field['require'] ) && ( $field['require'] == true ) ? $field['require'] : '';
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'wpx-meta-field';
        ob_start();
        ?>
            <tr class="text-field wpx-meta-field wpx-colorpicker-wrap  <?php echo $class; ?>  <?php echo $require; ?>" >
                <td><strong><label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label></strong></td>
                <td>
                    <input type="text" id="<?php echo $field['name']; ?>" class="wpx-colorpicker" name="<?php echo $field['name']; ?>" value="<?php echo esc_attr($value); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" <?php echo esc_attr($readonly); ?> <?php echo esc_attr($disabled); ?>>
                    <?php echo $this->field_description( $field ); ?>
                </td>
            </tr>
        <?php
        return ob_get_clean();
	}

	public function field_file( $field ){
		global $post; 
		$field['default'] = ( isset( $field['default'] ) ) ? $field['default'] : '';
        $value = get_post_meta( $post->ID, $field['name'], true ) != '' ? get_post_meta( $post->ID, $field['name'], true ) : $field['default']; 
		$class  = isset( $field['class'] ) && ! is_null( $field['class'] ) ? $field['class'] : 'wpx-meta-field';
		$disabled  = isset( $field['disabled'] ) && ( $field['disabled'] == true ) ? " disabled" : "";

        $id    = $field['name']  . '[' . $field['name'] . ']';
        $upload_button = isset( $field['upload_button'] ) ? $field['upload_button'] : __( 'Choose File' );
        $select_button = isset( $field['select_button'] ) ? $field['select_button'] : __( 'Select' );

        $image_data = explode(',',$value);

        $image_url = '';
        $alt = '';
        if (is_array($image_data) && !empty($image_data[1]) ) {
            $image_url = $image_data[1];
            $get_image_id = attachment_url_to_postid($image_url);
            $alt = get_post_meta ( $get_image_id, '_wp_attachment_image_alt', true );
        }  

        ob_start();
        ?>
            <tr class="text-field <?php echo $class;?>" >
                <td><strong><label for="<?php echo $field['name']; ?>"><?php echo $field['label']; ?></label></strong></td>
                <td>  
                    <div class="img-wrap">
                        <span class="img-remove">X</span>
                        <img class="image-preview <?php echo ( is_array($image_data) && !empty($image_data[1]) ) ? '' : 'hide'; ?>" src="<?php echo esc_url($image_url); ?>" width="100" height="70" alt="<?php echo esc_attr($alt); ?>"> 
                    </div>
                    <input type="hidden" class="wpx-img-field <?php echo $class; ?>" id="<?php echo $field['name']; ?>" name="<?php echo $field['name']; ?>" value="<?php echo $value; ?>" <?php echo $disabled; ?>> 
                    <input type="button" class="button wpx-browse" data-title="<?php esc_attr_e('Media Gallery'); ?>" data-select-text="<?php echo $select_button; ?>" value="<?php echo $upload_button; ?>"  <?php echo $disabled; ?>>
                    <?php echo $this->field_description( $field ); ?>
                </td>
            </tr>
        <?php 
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
                $('.wpx-browse').on('click', function (event) {
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
        <?php
    }
} 
