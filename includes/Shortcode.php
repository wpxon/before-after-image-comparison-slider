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
        ?>
            <div class="slider-preview">
                <div class="before">
                    <img class="slide-img" src="http://my-plugin.local/wp-content/uploads/2022/02/2.jpg">
                </div>
                <div class="after">
                    <img class="slide-img" src="http://my-plugin.local/wp-content/uploads/2022/02/1.png">
                </div>
            </div>
        <?php
        return ob_get_clean();
    }

}