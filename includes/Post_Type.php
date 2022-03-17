<?php  
namespace BAICS;

class Post_Type { 
	function __construct(){
		add_action( 'init', [ $this, 'register_image_comparison_post_type'] ); 
	}
	/**
	 * Register a image comparison slider post type called "baics". 
	 */
	function register_image_comparison_post_type() {
		$labels = [
			'name'                  => _x( 'Before After Image Slider', 'Post type general name', 'baics' ),
			'singular_name'         => _x( 'Before After Image Slider', 'Post type singular name', 'baics' ),
			'menu_name'             => _x( 'Before After Image Slider', 'Admin Menu text', 'baics' ),
			'name_admin_bar'        => _x( 'Slider', 'Add New on Toolbar', 'baics' ),
			'add_new'               => __( 'Add New', 'baics' ),
			'add_new_item'          => __( 'Add New Slider', 'baics' ),
			'new_item'              => __( 'New Slider', 'baics' ),
			'edit_item'             => __( 'Edit Slider', 'baics' ),
			'view_item'             => __( 'View Slider', 'baics' ),
			'all_items'             => __( 'All Sliders', 'baics' ),
			'search_items'          => __( 'Search Sliders', 'baics' ),
			'parent_item_colon'     => __( 'Parent Sliders:', 'baics' ),
			'not_found'             => __( 'No sliders found.', 'baics' ),
			'not_found_in_trash'    => __( 'No sliders found in Trash.', 'baics' ),
		];
	
		$args = [
			'labels'              => $labels,
			'public'              => false,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'query_var'           => true,
			'rewrite'             => false,
			'capability_type'     => 'post',
			'exclude_from_search' => true,
			'show_in_nav_menus'   => false,
			'has_archive'         => false,
			'hierarchical'        => false,
			'menu_position'       => null,
			'menu_icon'  		  => 'dashicons-format-gallery',
			'supports'            => [ 'title' ],
		];

		register_post_type( 'baics', $args );
	}

}
