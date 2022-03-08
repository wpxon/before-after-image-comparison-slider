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
                ),
            ),
            array(
                'id'    => 'style', 
                'title' => 'Style',
                'icon' => 'dashicons-image-filter',
                'fields' => array(
                    array(
                        'name'      =>  'ex_radio',
                        'label'     =>  __( 'Radio Field' ),
                        'type'      =>  'radio', 
                        'options'   => array(
                            'item_1'  => 'Item One',
                            'item_2'  => 'Item Two',
                            'item_3'  => 'Item Three',
                            ),
                        'default'   =>  'item_2',
                        'disabled'  =>  false, // true|false
                    ),
                    array(
                        'name'      =>  'sample_select',
                        'label'     =>  __( 'Select Field' ),
                        'type'      =>  'select', 
                        'options'   => array(
                            'option_1'  => 'Option One',
                            'option_2'  => 'Option Two',
                            'option_3'  => 'Option Three',
                            ),
                        'default'   =>  'option_2',
                        'disabled'  =>  false, // true|false
                        'multiple'  =>  true, // true|false
                    ),
                ),
            ),
            array(
                'id'    => 'settings', 
                'title' => 'Settings',
                'icon' => 'dashicons-admin-generic',
                'fields' => array(
                    array(
                        'name'      =>  'ex_checkbox',
                        'label'     =>  __( 'Checkbox Field' ),
                        'type'      =>  'checkbox',
                        'desc'      =>  __( 'This is a checkbox field.' ),
                        'class'     =>  '',
                        'disabled'  =>  false, // true|false
                    ),
                    array(
                        'name'      =>  'sample_fise',
                        'label'     =>  __( 'First Image' ),
                        'type'      =>  'file',
                        'upload_button'     =>  __( 'Upload/Edit Image' ),
                        'select_button'     =>  __( 'Select Image' ),
                        'desc'      =>  '',
                        'class'     =>  'image-field',
                        'disabled'  =>  false, // true|false
                        'default'   =>  'http://example.com/sample/file.txt'
                    ),
                    array(
                        'name'      =>  'sample_fise_2',
                        'label'     =>  __( 'Second Image' ),
                        'type'      =>  'file',
                        'upload_button'     =>  __( 'Upload/Edit Image' ),
                        'select_button'     =>  __( 'Select Image' ),
                        'desc'      =>  '',
                        'class'     =>  'image-field',
                        'disabled'  =>  false, // true|false
                        'default'   =>  ''
                    )
                )
            ),
            array(
                'id'    => 'settingsff', 
                'title' => 'tab alt', 
                'fields' => array(
                    array(
                        'name'      =>  'fex_checkbox',
                        'label'     =>  __( 'Checkbox Field' ),
                        'type'      =>  'checkbox',
                        'desc'      =>  __( 'This is a checkbox field.' ),
                        'class'     =>  '',
                        'disabled'  =>  false, // true|false
                    ),
                    array(
                        'name'      =>  'fsample_fise',
                        'label'     =>  __( 'First Image' ),
                        'type'      =>  'file',
                        'upload_button'     =>  __( 'Upload/Edit Image' ),
                        'select_button'     =>  __( 'Select Image' ),
                        'desc'      =>  '',
                        'class'     =>  'fimage-field',
                        'disabled'  =>  false, // true|false
                        'default'   =>  'http://example.com/sample/file.txt'
                    ),
                    array(
                        'name'      =>  'fsample_fise_2',
                        'label'     =>  __( 'Second Image' ),
                        'type'      =>  'file',
                        'upload_button'     =>  __( 'Upload/Edit Image' ),
                        'select_button'     =>  __( 'Select Image' ),
                        'desc'      =>  '',
                        'class'     =>  'image-field',
                        'disabled'  =>  false, // true|false
                        'default'   =>  ''
                    ),
                    array(
                        'name'      =>  'esx_radio',
                        'label'     =>  __( 'Radio Field' ),
                        'type'      =>  'radio', 
                        'options'   => array(
                            'item_1'  => 'Item One',
                            'item_2'  => 'Item Two',
                            'item_3'  => 'Item Three',
                            ),
                        'default'   =>  'item_2',
                        'disabled'  =>  false, // true|false
                    ),
                    array(
                        'name'      =>  'sampsle_select',
                        'label'     =>  __( 'Select Field' ),
                        'type'      =>  'select', 
                        'options'   => array(
                            'option_1'  => 'Option One',
                            'option_2'  => 'Option Two',
                            'option_3'  => 'Option Three',
                            ),
                        'default'   =>  'option_2',
                        'disabled'  =>  false, // true|false
                        'multiple'  =>  true, // true|false
                    ),
                    array(
                        'name'      =>  't1s',
                        'label'     =>  __( 'Tab 1' ),
                        'type'      =>  'text',  
                        'default'   =>  '',
                        'placeholder'   =>  'Hello World!',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ),
                    array(
                        'name'      =>  'tsa1',
                        'label'     =>  __( 'Tab 1' ),
                        'type'      =>  'text',  
                        'default'   =>  '',
                        'class'   =>  'no-sep',
                        'placeholder'   =>  'Hello World!',
                        'desc'   =>  'Hello World!',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ),
                    array(
                        'name'      =>  'tss1',
                        'label'     =>  __( 'Tab 1' ),
                        'type'      =>  'text',  
                        'default'   =>  '',
                        'class'   =>  'no-sep',
                        'placeholder'   =>  'Hello World!',
                        'desc'   =>  'Hello World!',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ), 
                    array(
                        'name'      =>  'tsf1',
                        'label'     =>  __( 'Tab 1' ),
                        'type'      =>  'text',  
                        'default'   =>  '',
                        'placeholder'   =>  'Hello World!',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ),
                    array(
                        'name'      =>  'ts2',
                        'label'     =>  __( 'Tab 1' ),
                        'type'      =>  'textarea',  
                        'default'   =>  '',
                        'placeholder'   =>  'Hello World!',
                        'columns'   =>  24,
                        'rows'      =>  5,
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    )
                )
            ),
        ),
        'fields'        =>  array( // if tab is FALSE
            array(
                'name'      =>  'sssample_text',
                'label'     =>  __( 'Text Field 2' ),
                'type'      =>  'text',
                'desc'      =>  __( 'This is a text field.' ),
                'class'     =>  'title',
                'default'   =>  '',
                'placeholder'   =>  'Hello World!',
                'readonly'  =>  false,
                'disabled'  =>  false,
            ) 
        )
    )
);



