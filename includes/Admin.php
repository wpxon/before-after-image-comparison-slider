<?php  
namespace BAICS;

class Admin{ 
	function __construct(){ 
		add_filter( 'manage_baics_posts_columns', [ $this, 'image_comparison_slider_columns' ] );
        add_action( 'manage_baics_posts_custom_column', [ $this, 'image_comparison_slider_column'], 10, 2);
	}

	public function image_comparison_slider_columns( $columns ) {
		
		$columns = array(
			'cb'             => $columns['cb'],
			'title'          => __( 'Title' ), 
			'shortcode'      => __( 'Shortcode', 'smashing' ),
			'sliderpreview'  => __( 'Slider Preview', 'smashing' ),
			'date'           => __( 'Date', 'smashing' ),
		);
	 
		return $columns;
	}

    function image_comparison_slider_column( $column, $post_id ) {
        // Shortcode column
        if ( 'shortcode' === $column ) {
            echo '[baics id="'.$post_id.'"]';
        } 
        // Slider preview column
        if ( 'sliderpreview' === $column ) {
            echo 'preview';
        }
    }
}