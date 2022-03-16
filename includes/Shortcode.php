<?php

namespace BAICS;

class Shortcode {

	function __construct(){
        add_shortcode('baics', [$this, 'image_comparison_slider']);
    }

    public function image_comparison_slider( $atts, $content = null ) {
        extract( shortcode_atts( [
            'id' => ''
        ], $atts ) ); 

        ob_start();  

        $before_image = get_post_meta( $id, 'before_image', true );
        $after_image  = get_post_meta( $id, 'after_image', true ); 

        $before_img_data = explode(',',$before_image);
        $after_img_data = explode(',',$after_image);

        if (is_array($before_img_data) && !empty($before_img_data[1]) ) {
            $before_img_url = $before_img_data[1];
        }
        if (is_array($after_img_data) && !empty($after_img_data[1]) ) {
            $after_img_url = $after_img_data[1];
        } 
        ?>
            <div class="slider-preview vertical">
                <div class="before">
                    <img class="slide-img" src="<?php echo esc_url($before_img_url); ?>">
                </div>
                <div class="after">
                    <img class="slide-img" src="<?php echo esc_url($after_img_url); ?>">
                </div>
                <div class="scroller">
                    <svg class="scroller__thumb" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                        <polygon points="0 50 37 68 37 32 0 50" style="fill:#fff"/>
                        <polygon points="100 50 64 32 64 68 100 50" style="fill:#fff"/>
                    </svg>
                </div>
            </div> 
        <?php 
        return ob_get_clean();
    }

}