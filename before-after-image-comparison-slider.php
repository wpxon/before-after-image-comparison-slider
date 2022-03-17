<?php 
/**
 * Plugin name: Before After Image Comparison Slider for WordPress
 * Plugin URI: http://wpxon.com/plugins/before-after-image-compariosn-slider
 * Description: A image comparison plugin for WordPress.
 * Version: 1.0.0
 * Author: WPxon
 * Author URI: http://wpxon.com
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: baics
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) || exit;


define('BAICS_PATH', __DIR__);
define('BAICS_ASSETS', plugins_url( '', __FILE__) . '/assets');
define('BAICS_SRC', BAICS_PATH . '/includes'); 

require_once __DIR__ . '/vendor/autoload.php';
// Initialize post type.
new BAICS\Post_Type();
// Initialize admin setigns
new BAICS\Admin();
new BAICS\Assets();
new BAICS\Shortcode();

wpx_metabox(
    array(
        'meta_box_id'   =>  'ex_meta_id',
        'label'         =>  __( 'Example Metabox' ),
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
                        'default'   =>  '0px',
                        'placeholder'   =>  '0px',
                        'class'   =>  'no-sep',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ),
                    array(
                        'name'      =>  'slider_shadow_v_offset',
                        'label'     =>  __( 'V Offset' ),
                        'type'      =>  'text',  
                        'require'      =>  'slider_shadow_switch', 
                        'default'   =>  '10px',
                        'placeholder'   =>  '10px',
                        'class'   =>  'no-sep',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ),
                    array(
                        'name'      =>  'slider_shadow_blur',
                        'label'     =>  __( 'Blur' ),
                        'type'      =>  'text',  
                        'require'      =>  'slider_shadow_switch', 
                        'default'   =>  '20px',
                        'placeholder'   =>  '20px',
                        'class'   =>  'no-sep',
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
                        'placeholder'   =>  '20px',
                        'class'   =>  'no-sep',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                        'desc'  => __( 'Insert percentage value of 100 except %. Ex: 20,40,60' ),
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



