<?php  
namespace BAICS;

class Post_Type { 
	function __construct(){
		add_action( 'init', [ $this, 'register_image_comparison_post_type'] );
		// add_action( 'init', [ $this, 'register_image_comparison_taxonomy'] );
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
	
	/**
	 * Register a image comparison slider taxonomy called "baics_category". 
	 */
	function register_image_comparison_taxonomy() { 
	 
		// Add new taxonomy to image slider post type
		$labels = array(
			'name'                       => _x( 'Categories', 'taxonomy general name', 'baics' ),
			'singular_name'              => _x( 'Category', 'taxonomy singular name', 'baics' ),
			'search_items'               => __( 'Search Categories', 'baics' ),
			'popular_items'              => __( 'Popular Categories', 'baics' ),
			'all_items'                  => __( 'All Categories', 'baics' ),
			'parent_item'                => null,
			'parent_item_colon'          => null,
			'edit_item'                  => __( 'Edit Category', 'baics' ),
			'update_item'                => __( 'Update Category', 'baics' ),
			'add_new_item'               => __( 'Add New Category', 'baics' ),
			'new_item_name'              => __( 'New Category Name', 'baics' ),
			'separate_items_with_commas' => __( 'Separate writers with commas', 'baics' ),
			'add_or_remove_items'        => __( 'Add or remove writers', 'baics' ),
			'choose_from_most_used'      => __( 'Choose from the most used writers', 'baics' ),
			'not_found'                  => __( 'No writers found.', 'baics' ),
			'menu_name'                  => __( 'Categories', 'baics' ),
		);
	 
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
	 
		register_taxonomy( 'baics_category', 'baics', $args );
	}

}
