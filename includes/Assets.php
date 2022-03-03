<?php 
namespace BAICS;
 
/**
 * Scripts and Styles Class
 */
class Assets {

    function __construct() {
        // add_action( 'wp_enqueue_scripts', [ $this, 'styles' ], 5 );
        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', [ $this, 'admin_assets' ], 5 );
        } 
    } 
 
    public function admin_assets() {
    	wp_enqueue_style( 'baics-admin', BAICS_ASSETS . '/css/admin.css' );
        wp_enqueue_script( 'gabaicsu-admin', BAICS_ASSETS . '/js/admin.js', ['jquery'], '', true );
    }  
}
