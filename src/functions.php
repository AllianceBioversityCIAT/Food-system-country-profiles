<?php
/**
 * Functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 * @package fscp-theme.
 */

if ( !defined( '_S_VERSION' ) ) {
    // Replace the version number of the theme on each release.
    $theme_version = wp_get_theme()->get( 'Version' );
    define( '_S_VERSION', $theme_version );
}

/**
 * Asynchronous scripts in the queue
 **/
function add_async_to_script( $tag, $handle, $src ) {
    if ( !is_admin() ) {
        $tag = str_replace( ' src', ' defer src', $tag );
    }

    return $tag;
}

add_filter( 'script_loader_tag', 'add_async_to_script', 10, 3 );

/**
 * Disable Gutenberg
 */
add_filter( 'use_block_editor_for_post', '__return_false', 10 );

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
foreach ( glob( dirname( __FILE__ ) . '/theme/inc/*-functions.php' ) as $filename ) {
    require $filename;
}

require get_theme_file_path() . '/theme/register-plugins.php';