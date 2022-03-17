<?php 
namespace BAICS;
 
/**
 * Scripts and Styles Class
 */
class Assets {

    function __construct() { 
        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', [ $this, 'admin_assets' ], 5 );
        } else{
            add_action( 'wp_enqueue_scripts', [ $this, 'frontend_assets' ], 5 );
        }
    } 
 
    public function admin_assets() {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_media();
    	wp_enqueue_style( 'baics-admin', BAICS_ASSETS . '/css/admin.css',[], md5_file(BAICS_ASSETS . '/css/admin.css'),'all' );
        
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'baics-admin', BAICS_ASSETS . '/js/admin.js', ['jquery'], md5_file(BAICS_ASSETS . '/js/admin.js'), true );
    }  
 
    public function frontend_assets() {
    	wp_enqueue_style( 'baics-style', BAICS_ASSETS . '/css/style.css',[], md5_file(BAICS_ASSETS . '/css/style.css'),'all' );
        wp_enqueue_script( 'baics-script', BAICS_ASSETS . '/js/script.js', [], md5_file(BAICS_ASSETS . '/js/script.js'), true );
    }  
}
