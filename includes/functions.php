<?php

if ( ! function_exists( 'wpx_metabox' ) ) {
	function wpx_metabox( $args ){
		return new BAICS\Metabox( $args );
	}
}

// meta field initializes.
wpx_metabox(
    array(
        'meta_box_id'   =>  'baics_meta',
        'label'         =>  __( 'Slider before/after content' ),
        'post_type'     =>  array( 'baics' ),
        'context'       =>  'normal', // side|normal|advanced
        'priority'      =>  'high', // high|low
        'hook_priority' =>  10,
        'tab'           =>  true, // true|false
        'tabs' => array( // if tab is TRUE
            array(
                'id'    => 'content', 
                'title' => 'Content',
                'icon' => 'dashicons-edit-large',
                'fields' => array(
                    array(
                        'name'      =>  'before_image',
                        'label'     =>  __( 'Before Image' ),
                        'type'      =>  'file',
                        'upload_button'     =>  __( 'Upload/Edit Image' ),
                        'select_button'     =>  __( 'Select Image' ),
                        'desc'      =>  '',
                        'class'     =>  '',
                        'disabled'  =>  false, // true|false
                        'default'   =>  ''
                    ),
                    array(
                        'name'      =>  'after_image',
                        'label'     =>  __( 'After Image' ),
                        'type'      =>  'file',
                        'upload_button'     =>  __( 'Upload/Edit Image' ),
                        'select_button'     =>  __( 'Select Image' ),
                        'desc'      =>  '',
                        'class'     =>  '',
                        'disabled'  =>  false, // true|false
                        'default'   =>  ''
                    ),
                    array(
                        'name'      =>  'layout',
                        'label'     =>  __( 'Orientation Layout' ),
                        'type'      =>  'radio', 
                        'options'   => array(
                            'horizontal'  => 'Horizontal', 
                            'vertical'  => 'Vertical'
                            ),
                        'default'   =>  'horizontal',
                        'disabled'  =>  false, // true|false
                    )
                ),
            ),
            array(
                'id'    => 'style', 
                'title' => 'Style',
                'icon' => 'dashicons-image-filter',
                'fields' => array(
                    array(
                        'name'      =>  'slider_shadow_switch',
                        'label'     =>  __( 'Slider Box Shadow' ),
                        'type'      =>  'radio', 
                        'options'   => array(
                                'on'  => 'On',
                                'off'  => 'Off'
                            ),
                        'default'   =>  'on',
                        'class'   =>  'no-sep',
                        'disabled'  =>  false, // true|false
                    ),
                    array(
                        'name'      =>  'slider_shadow_h_offset',
                        'label'     =>  __( 'H Offset' ),
                        'type'      =>  'text',  
                        'require'      =>  'slider_shadow_switch',  
                        'default'   =>  '0',
                        'placeholder'   =>  '0',
                        'class'   =>  'short no-sep',
                        'ext'  => 'px',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ),
                    array(
                        'name'      =>  'slider_shadow_v_offset',
                        'label'     =>  __( 'V Offset' ),
                        'type'      =>  'text',  
                        'require'      =>  'slider_shadow_switch', 
                        'default'   =>  '10',
                        'placeholder'   =>  '10',
                        'class'   =>  'short no-sep',
                        'ext'  => 'px',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ),
                    array(
                        'name'      =>  'slider_shadow_blur',
                        'label'     =>  __( 'Blur' ),
                        'type'      =>  'text',  
                        'require'      =>  'slider_shadow_switch', 
                        'default'   =>  '20',
                        'placeholder'   =>  '20',
                        'class'   =>  'short no-sep',
                        'ext'  => 'px',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ),
                    array(
                        'name'      =>  'slider_shadow_color',
                        'label'     =>  __( 'Shadow Color' ),
                        'type'      =>  'colorpicker',  
                        'require'      =>  'slider_shadow_switch', 
                        'default'   =>  '',
                        'placeholder'   =>  '',
                        'class'   =>  'no-sep',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ),
                    array(
                        'name'      =>  'slider_handle_color',
                        'label'     =>  __( 'Handle Color' ),
                        'type'      =>  'colorpicker',  
                        'default'   =>  '',
                        'placeholder'   =>  '',
                        'class'   =>  '',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ) 
                ),
            ),
            array(
                'id'    => 'settings', 
                'title' => 'Settings',
                'icon' => 'dashicons-admin-generic',
                'fields' => array(
                    array(
                        'name'      =>  'slider_img_offset',
                        'label'     =>  __( 'Offset' ),
                        'type'      =>  'text',   
                        'default'   =>  '50',
                        'placeholder'   =>  '50',
                        'class'   =>  'short no-sep',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                        'desc'  => __( 'Insert percentage value of 100. Ex: 20,40,60' ),
                        'ext'  => '%',
                    ),
                    array(
                        'name'      =>  'slider_on_mouseover',
                        'label'     =>  __( 'Slide on Mouse hover' ),
                        'type'      =>  'radio', 
                        'options'   => array(
                                'on'  => 'On',
                                'off'  => 'Off'
                            ),
                        'default'   =>  'off',
                        'class'   =>  'no-sep',
                        'disabled'  =>  false, // true|false
                    ),
                )
            )
        ) 
    )
);
