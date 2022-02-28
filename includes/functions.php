<?php

if ( ! function_exists( 'wpx_metabox' ) ) {
	function wpx_metabox( $args ){
		return new BAICS\Metabox( $args );
	}
}