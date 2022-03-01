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
                'id'    => 'tab_1', 
                'title' => 'Tab 1',
                'fields' => array(
                    array(
                        'name'      =>  't1',
                        'label'     =>  __( 'Tab 1' ),
                        'type'      =>  'text',  
                        'default'   =>  '',
                        'placeholder'   =>  'Hello World!',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ),
                    array(
                        'name'      =>  't2',
                        'label'     =>  __( 'Tab 1' ),
                        'type'      =>  'textarea',  
                        'default'   =>  '',
                        'placeholder'   =>  'Hello World!',
                        'columns'   =>  24,
                        'rows'      =>  5,
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    )
                ),
            ),
            array(
                'id'    => 'tab_2', 
                'title' => 'Tab 2',
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
                'id'    => 'tab_3', 
                'title' => 'Tab 3',
                'fields' => array(
                    array(
                        'name'      =>  'ex_checkbox',
                        'label'     =>  __( 'Checkbox Field' ),
                        'type'      =>  'checkbox',
                        'desc'      =>  __( 'This is a checkbox field.' ),
                        'class'     =>  '',
                        'disabled'  =>  false, // true|false
                    )
                ),
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