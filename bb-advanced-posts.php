<?php
/*
Plugin Name: Beaver Builder Advanced Posts Module
Plugin URI:
Description: Beaver Builder Advanced Posts Module
Author: Pancake Creative
Version:
Author URI:
*/

define( 'BBAP_MODULES_DIR', plugin_dir_path( __FILE__ ) );
define( 'BBAP_MODULES_URL', plugins_url( '/', __FILE__ ) );

function my_get_field( $field ) {
	if ( is_callable('get_field') ) {
		return get_field( $field );
	} else {
		return get_post_meta( get_the_ID(), $field, true );
	}
}

function bbap_load_module() {
    if ( class_exists( 'FLBuilder' ) ) {
        require_once 'bb-advanced-posts-module.php';
    }

    add_action('wp_footer', function() {
?>
        <style type="text/css">
            /* CTA */
            .fl-post-cta-button {
                background-color: #0000ed;
                color: #fff;
                line-height: 30px;
                font-size: 20px;
                padding: 0 10px;
                display: inline-block;
            }

            .fl-post-cta-button:hover {
                color: #eee;
            }
        </style>
<?php
    });
}
add_action( 'init', 'bbap_load_module' );