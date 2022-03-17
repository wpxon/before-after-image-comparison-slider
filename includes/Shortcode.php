<?php

namespace BAICS;

class Shortcode {

	function __construct(){
        add_shortcode('baics', [$this, 'image_comparison_slider']);
        add_action('baics_styles', [$this, 'image_comparison_slider_styles'], 10, 1 ); 
    }

    public function image_comparison_slider( $atts, $content = null ) {
        extract( shortcode_atts( [
            'id' => ''
        ], $atts ) ); 

        ob_start();  

        $before_image = get_post_meta( $id, 'before_image', true );
        $after_image  = get_post_meta( $id, 'after_image', true ); 
        $layout       = get_post_meta( $id, 'layout', true ); 
        $shadow       = get_post_meta( $id, 'slider_shadow_switch', true ); 
        $img_offset   = get_post_meta( $id, 'slider_img_offset', true ); 
        $mouseover    = get_post_meta( $id, 'slider_on_mouseover', true ); 

        $before_img_data = explode(',',$before_image);
        $after_img_data  = explode(',',$after_image);

        if (is_array($before_img_data) && !empty($before_img_data[1]) ) {
            $before_img_url = $before_img_data[1];
        }
        if (is_array($after_img_data) && !empty($after_img_data[1]) ) {
            $after_img_url = $after_img_data[1];
        } 
        do_action( 'baics_styles', $id );
        ?>
            <div id="baics-<?php echo esc_attr($id); ?>" class="slider-preview <?php echo esc_attr($layout ? $layout : 'horizontal'); ?> <?php echo esc_attr(($shadow == 'on' ) ? 'shadow' : ''); ?>" data-layout="<?php echo esc_attr($layout ? $layout : 'horizontal'); ?>" data-offset="<?php echo esc_attr($img_offset ? $img_offset : 50); ?>" data-auto-mousemove="<?php echo esc_attr($mouseover ? $mouseover : 'off'); ?>">
                <div class="before">
                    <img class="slide-img" src="<?php echo esc_url($before_img_url); ?>">
                </div>
                <div class="after">
                    <img class="slide-img" src="<?php echo esc_url($after_img_url); ?>">
                </div>
                <div class="scroller">
                    <svg class="scroller__thumb" xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                        <polygon points="0 50 37 68 37 32 0 50"/>
                        <polygon points="100 50 64 32 64 68 100 50"/>
                    </svg>
                </div>
            </div> 
        <?php 
        return ob_get_clean();
    }

    public function image_comparison_slider_styles( $id )    {
        $shadow        = get_post_meta( $id, 'slider_shadow_switch', true ); 
        $h_offset      = get_post_meta( $id, 'slider_shadow_h_offset', true ); 
        $v_offset      = get_post_meta( $id, 'slider_shadow_v_offset', true ); 
        $blur          = get_post_meta( $id, 'slider_shadow_blur', true ); 
        $shadow_color  = get_post_meta( $id, 'slider_shadow_color', true ); 
        $handle_color  = get_post_meta( $id, 'slider_handle_color', true ); 
        $box_width     = get_post_meta( $id, 'slider_box_width', true ); 
        $box_height    = get_post_meta( $id, 'slider_box_height', true ); 
        ?>
            <style> 
                <?php if(!empty($box_width) && !empty($box_height)): ?>
                    #baics-<?php echo esc_attr($id); ?>.slider-preview{
                        width: <?php echo esc_attr($box_width ?: 0); ?>px !important;
                        height: <?php echo esc_attr($box_height ?: 0); ?>px !important;
                    }
                <?php endif; ?>
                <?php if($shadow == 'on'): ?>
                    #baics-<?php echo $id; ?>.slider-preview{
                        box-shadow: <?php echo esc_attr($h_offset ?: 0); ?>px <?php echo esc_attr($v_offset ?: 0); ?>px <?php echo esc_attr($blur ?: 0); ?>px <?php echo esc_attr($shadow_color); ?>;
                    }
                <?php endif; ?>
                <?php if(!empty($handle_color)): ?>
                    #baics-<?php echo esc_attr($id); ?>.slider-preview .scroller{
                        border-color: <?php echo esc_attr($handle_color); ?>;
                    }
                    #baics-<?php echo esc_attr($id); ?>.slider-preview .scroller:before, 
                    #baics-<?php echo esc_attr($id); ?>.slider-preview .scroller:after{
                        background-color: <?php echo esc_attr($handle_color); ?>;
                    }
                    #baics-<?php echo esc_attr($id); ?>.slider-preview .scroller svg polygon{
                        fill: <?php echo esc_attr($handle_color); ?>;
                    }
                <?php endif; ?>
            </style>
        <?php
    }
}