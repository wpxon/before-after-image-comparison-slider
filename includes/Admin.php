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
            echo '<input class="shortcode-display" type=\'text\' value=\'[baics id="'.$post_id.'"]\' readonly>';
			echo '<span class="copytext-notice hide">Shortcode Copied</span>';
        } 
        // Slider preview column
        if ( 'sliderpreview' === $column ) {
			$before_img_url = '';
			$after_img_url = '';
			$before_img = get_post_meta( $post_id, 'before_image', true ) != '' ? get_post_meta( $post_id, 'before_image', true ) :''; 
			$after_img = get_post_meta( $post_id, 'after_image', true ) != '' ? get_post_meta( $post_id, 'after_image', true ) :''; 

			$before_img_data = explode(',',$before_img);
			$after_img_data = explode(',',$after_img);

			if (is_array($before_img_data) && !empty($before_img_data[1]) ) {
				$before_img_url = $before_img_data[1];
			}
			if (is_array($after_img_data) && !empty($after_img_data[1]) ) {
				$after_img_url = $after_img_data[1];
			} 
			if( !empty($before_img_url) || !empty($after_img_url) ) {
				echo '<div class="slider-preview">';
				echo '<div class="before"><img class="slide-img" src="'.$before_img_url.'"></div>';
				echo '<div class="after"><img class="slide-img" src="'.$after_img_url.'"></div>';
				echo '</div>';
			} 
        }
    }
}