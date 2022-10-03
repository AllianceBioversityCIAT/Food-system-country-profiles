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
 * Enqueue scripts and styles.
 */
function main_theme_scripts() {
    global $template;
    $path          = get_stylesheet_directory();
    $template_name = basename( $template, ".php" );
    $css_name      = "/static/css/$template_name.css";
    $js_name       = "/static/js/$template_name.min.js";

    if ( file_exists( $path . $css_name ) ) {

        //CSS template_name
        wp_enqueue_style( 'fscp-css-' . $template_name, get_stylesheet_directory_uri() . '/static/css/' . $template_name . '.css', array(), _S_VERSION );
    }

    if ( file_exists( $path . $js_name ) ) {

        if ( $template_name === 'page-dashboard' ) {
            wp_enqueue_script( 'fscp-chart-js', get_stylesheet_directory_uri() . '/static/lib/chart.js/dist/chart.js', array('jquery'), 'latest', true );

            wp_enqueue_script( 'fscp-html2canvas-js', get_stylesheet_directory_uri() . '/static/lib/html2canvas/dist/html2canvas.min.js', array('jquery'), 'latest', true );

            wp_enqueue_script( 'fscp-' . $template_name, get_stylesheet_directory_uri() . '/static/js/' . $template_name . '.min.js', array( 'fscp-html2canvas-js', 'jquery', 'fscp-chart-js', ), _S_VERSION );

            wp_localize_script( 'fscp-' . $template_name, 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
        }
    }
}

add_action( 'wp_enqueue_scripts', 'main_theme_scripts' );

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