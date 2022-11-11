<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package fscp-theme.
 */

function sfcs_acf_op_init() {

    // Check function exists.
    if ( function_exists( 'acf_add_options_page' ) ) {

        // Add parent.
        acf_add_options_page( array(
            'page_title'      => __('Theme General Settings'),
            'menu_title'      => __('Theme Settings'),
            'menu_slug'       => 'sfcs-theme-general-settings',
            'capability'      => 'edit_posts',
            'icon_url'        => 'dashicons-admin-settings',
            'redirect'        => false,
            'update_button'   => 'Save options',
            'updated_message' => 'Options saved',
            'post_id'         => 'sfcs-theme-general-settings',
        ) );
    }
}

add_action( 'acf/init', 'sfcs_acf_op_init' );

function acf_enqueue_admin_script_sfcs( $hook ) {

    if ( 'toplevel_page_sfcs-theme-general-settings' != $hook ) {
        return;
    }

    wp_enqueue_script( 'acf-settings-page', get_stylesheet_directory_uri() . '/static/js/admin/acf-settings-page.min.js' );
    wp_localize_script( 'acf-settings-page', 'ajax_var', array(
        'url'    => admin_url( 'admin-ajax.php' ),
        'nonce'  => wp_create_nonce( 'foresight-ajax-nonce' ),
        'fileCreation'  => get_stylesheet_directory_uri() . '/static/files/creation-indicators.csv',
    ));
}

add_action( 'admin_enqueue_scripts', 'acf_enqueue_admin_script_sfcs' );