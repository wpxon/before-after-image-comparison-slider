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

require_once __DIR__ . '/vendor/autoload.php';
// Initialize post type.
new BAICS\Post_Type();
// Initialize admin setigns
new BAICS\Admin();

wpx_metabox(
    array(
        'meta_box_id'   =>  'sssample_meta_id',
        'label'         =>  __( 'Sample Meta Box 2' ),
        'post_type'     =>  array( 'baics' ),
        'context'       =>  'normal', // side|normal|advanced
        'priority'      =>  'high', // high|low
        'hook_priority' =>  10,
        'tab'           =>  true,
        'tabs' => array(
            array(
                'id'    => 'tab_1', 
                'title' => 'Tab 1',
                'fields' => array(
                    array(
                        'name'      =>  't1',
                        'label'     =>  __( 'Tab 1' ),
                        'type'      =>  'text',
                        'desc'      =>  __( 'This is a text field.' ),
                        'class'     =>  'title',
                        'default'   =>  'Hello World!',
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
                        'name'      =>  'te',
                        'label'     =>  __( 'Tab 2' ),
                        'type'      =>  'text',
                        'desc'      =>  __( 'This is a text field.' ),
                        'class'     =>  'title',
                        'default'   =>  'Hello World!',
                        'readonly'  =>  false,
                        'disabled'  =>  false,
                    ) 
                ),
            ),
        ),
        'fields'        =>  array( 
            array(
                'name'      =>  'sssample_text',
                'label'     =>  __( 'Text Field 2' ),
                'type'      =>  'text',
                'desc'      =>  __( 'This is a text field.' ),
                'class'     =>  'title',
                'default'   =>  'Hello World!',
                'readonly'  =>  false,
                'disabled'  =>  false,
            ) 
        )
    )
);