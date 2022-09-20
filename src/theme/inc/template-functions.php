<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package fscp-theme.
 */

/**
 * This foreach will be in charge of registering the fields of the ACF.
 */
foreach ( glob( dirname( __FILE__ ) . '/acf-init/*.php' ) as $filename ) {
    require $filename;
}

function register_vars_js() {
    global $template;
    $path          = get_stylesheet_directory();
    $template_name = basename( $template, ".php" );
    $js_name       = "/static/js/$template_name.min.js";

    if ( file_exists( $path . $js_name ) ) {

        if ( $template_name === 'page-dashboard' ) {
            $get_country   = ( isset( $_GET[ 'country' ] ) ) ? sanitize_text_field( $_GET[ 'country' ] ) : '';
            $constant_vars = [
                'country' => $get_country,
            ];

            wp_localize_script( 'fscp-' . $template_name, 'constantVars', $constant_vars );
        }
    }
}

add_action( 'wp_enqueue_scripts', 'register_vars_js' );