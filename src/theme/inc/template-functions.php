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

/**
 * Add css and js files in admin edit/new views
 * for general purposes only
 *
 * @param string $hook_suffix
 */
function wp_admin_cpt_enqueue( $hook_suffix ) {

    if ( in_array( $hook_suffix, [ 'post.php', 'post-new.php', 'edit.php' ] ) ) {

        $screen   = get_current_screen();
        $cpt      = ( !empty( $screen->post_type ) ) ? $screen->post_type : $screen->id;
        $path     = get_theme_file_path();
        $js_name  = "/static/js/admin/admin-$cpt.min.js";

        if ( file_exists( $path . $js_name ) ) {
            wp_enqueue_script( "admin-$cpt", get_stylesheet_directory_uri() . $js_name );

            wp_localize_script(
                "admin-$cpt",
                "adminVars",
                array(
                    $cpt . "_nonce" => wp_create_nonce( $cpt . "_nonce" ), // Create nonce which we later will use to verify AJAX request
                )
            );
        }
    }
}

add_action( 'admin_enqueue_scripts', 'wp_admin_cpt_enqueue' );

/**
 * @param $post_id int|string
 *
 * @return void
 */
function wp_update_fields_indicators( $post_id ) {

    // get our current post object
    $post = get_post( $post_id );

    // if post is object
    if ( is_object( $post ) ) {

        // check we are on the team custom type and post status is either publish or draft
        if ( $post->post_type === 'country-profile' && ( $post->post_status === 'publish' || $post->post_status === 'draft' ) ) {

            // Get all custom fields.
            $fields = get_fields( $post_id );

            // Fields Country.
            $c_difference          = (float) $fields[ 'country_last_measure' ] - $fields[ 'country_initial_measure' ];
            $c_growth_rate         = round( (float) ( $c_difference / $fields[ 'country_initial_measure' ] ) * 100, 2 );
            $c_final_status_growth = final_status_growth( $c_growth_rate, $fields[ 'type_growth_indicator' ][ 'value' ] );
            $c_consolidated_value  = consolidated_value( $c_final_status_growth );

            // Update fields country.
            update_field( 'country_difference', $c_difference, $post_id );
            update_field( 'country_growth_rate', $c_growth_rate, $post_id );
            update_field( 'country_final_status', $c_final_status_growth, $post_id );
            update_field( 'country_consolidated_value', $c_consolidated_value, $post_id );

            // Fields Geographic neighbors.
            $gn_difference          = (float) $fields[ 'gn_last_measure' ] - $fields[ 'gn_initial_measure' ];
            $gn_growth_rate         = round( (float) ( $gn_difference / $fields[ 'gn_initial_measure' ] ) * 100, 2 );
            $gn_final_status_growth = final_status_growth( $gn_growth_rate, $fields[ 'type_growth_indicator' ][ 'value' ] );
            $gn_consolidated_value  = consolidated_value( $gn_final_status_growth );

            // Update fields Geographic neighbors.
            update_field( 'gn_difference', $gn_difference, $post_id );
            update_field( 'gn_growth_rate', $gn_growth_rate, $post_id );
            update_field( 'gn_final_status', $gn_final_status_growth, $post_id );
            update_field( 'gn_consolidated_value', $gn_consolidated_value, $post_id );

            // Fields Countries with similar GDP.
            $gdp_difference          = (float) $fields[ 'gdp_last_measure' ] - $fields[ 'gdp_initial_measure' ];
            $gdp_growth_rate         = round( (float) ( $gdp_difference / $fields[ 'gdp_initial_measure' ] ) * 100, 2 );
            $gdp_final_status_growth = final_status_growth( $gdp_growth_rate, $fields[ 'type_growth_indicator' ][ 'value' ] );
            $gdp_consolidated_value  = consolidated_value( $gdp_final_status_growth );

            // Update fields Countries with similar GDP.
            update_field( 'gdp_difference', $gdp_difference, $post_id );
            update_field( 'gdp_growth_rate', $gdp_growth_rate, $post_id );
            update_field( 'gdp_final_status', $gdp_final_status_growth, $post_id );
            update_field( 'gdp_consolidated_value', $gdp_consolidated_value, $post_id );

            // Fields Global average.
            $ga_difference          = (float) $fields[ 'ga_last_measure' ] - $fields[ 'ga_initial_measure' ];
            $ga_growth_rate         = round( (float) ( $ga_difference / $fields[ 'ga_initial_measure' ] ) * 100, 2 );
            $ga_final_status_growth = final_status_growth( $ga_growth_rate, $fields[ 'type_growth_indicator' ][ 'value' ] );
            $ga_consolidated_value  = consolidated_value( $ga_final_status_growth );

            // Update fields Global average.
            update_field( 'ga_difference', $ga_difference, $post_id );
            update_field( 'ga_growth_rate', $ga_growth_rate, $post_id );
            update_field( 'ga_final_status', $ga_final_status_growth, $post_id );
            update_field( 'ga_consolidated_value', $ga_consolidated_value, $post_id );
        }
    }

    // finally return
    return;
}

add_action( 'acf/save_post', 'wp_update_fields_indicators', 20 );

function final_status_growth( $growth_value, $type_growth ) {
    $status_growth = '';

    if ( $growth_value > 5 ) {
        $status_growth = 'improve';

        if ( $type_growth === 'inverted' ) {
            $status_growth = 'deteriorate';
        }

    } else if ( $growth_value < -5 ) {
        $status_growth = 'deteriorate';

        if ( $type_growth === 'inverted' ) {
            $status_growth = 'improve';
        }

    } else {
        $status_growth = 'unchanged';
    }

    return $status_growth;
}

function consolidated_value( $status_growth ) {

    if ( $status_growth === 'deteriorate' ) {
        return -1;
    }

    return 0;
}
