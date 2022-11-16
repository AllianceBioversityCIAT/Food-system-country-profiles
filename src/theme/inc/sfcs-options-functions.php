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
            'page_title'      => __( 'Theme General Settings' ),
            'menu_title'      => __( 'Theme Settings' ),
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
        'url'          => admin_url( 'admin-ajax.php' ),
        'nonce'        => wp_create_nonce( 'foresight-ajax-nonce' ),
        'fileCreation' => get_stylesheet_directory_uri() . '/static/files/creation-indicators.csv',
    ) );
}

add_action( 'admin_enqueue_scripts', 'acf_enqueue_admin_script_sfcs' );

/**
 * Load options on Company Name in user.
 */
function acf_load_select_country( $field ) {

    $field[ 'choices' ][ '' ] = "";
    $customers                = get_terms( array(
        'taxonomy'   => 'country',
        'hide_empty' => false,
    ) );

    if ( !empty( $customers ) ) {
        foreach ( $customers as $key => $value ) {
            $field[ 'choices' ][ $value->slug ] = $value->name;
        }
    }

    return $field;
}

add_filter( 'acf/load_field/key=field_indicator_country', 'acf_load_select_country' );

/**
 * This function gets the country and the csv to create the indicators.
 */
function wp_import_csv_indicators() {
    $screen = get_current_screen();
    $data   = $_POST;

    if ( 'toplevel_page_sfcs-theme-general-settings' === $screen->id ) {
        $head_array = [
            0  => 'name',
            1  => 'component',
            2  => 'short-description',
            3  => 'indicator-units',
            4  => 'period-initial',
            5  => 'period-recent',
            6  => 'type-of-growth',
            7  => 'country-initial-measure',
            8  => 'country-last-measure',
            9  => 'gdp-initial-measure',
            10 => 'gdp-last-measure',
            11 => 'neighbors-initial-measure',
            12 => 'neighbors-last-measure',
            13 => 'global-initial-measure',
            14 => 'global-last-measure',
        ];

        $fileID            = $data[ 'acf' ][ 'field_import_csv_indicators' ];
        $term_slug_country = $data[ 'acf' ][ 'field_indicator_country' ];
        $rows              = [];
        $ind               = [];
        $indicators        = [];

        if ( !empty( $fileID ) ) {
            ob_start();
            $file_url = wp_get_attachment_url( $fileID );
            $handle   = fopen( $file_url, 'r' );

            // Importing data from csv.
            while ( ( $data = fgetcsv( $handle, 1000, ";" ) ) !== false ) {
                $rows[] = $data;
            }
            ob_end_clean();
            // Headers are removed.
            unset( $rows[ 0 ] );

            // Change Keys.
            foreach ( $rows as $key => $value ) {

                foreach ( $value as $k => $val ) {
                    $ind[ $head_array[ $k ] ] = $val;
                }
                $indicators[] = $ind;
            }

            foreach ( $indicators as $indicator ) {
                $term_slug_component = $indicator[ 'component' ];
                $post                = [
                    'post_title'  => $indicator[ 'name' ],
                    'post_type'   => 'country-profile',
                    'post_status' => 'publish',
                    'post_author' => get_current_user_id(),
                ];

                // Converting calculation variables to float.
                $c_initial   = (float) normalizeDecimal( $indicator[ 'country-initial-measure' ] );
                $c_last      = (float) normalizeDecimal( $indicator[ 'country-last-measure' ] );
                $gn_initial  = (float) normalizeDecimal( $indicator[ 'neighbors-initial-measure' ] );
                $gn_last     = (float) normalizeDecimal( $indicator[ 'neighbors-last-measure' ] );
                $gdp_initial = (float) normalizeDecimal( $indicator[ 'gdp-initial-measure' ] );
                $gdp_last    = (float) normalizeDecimal( $indicator[ 'gdp-last-measure' ] );
                $ga_initial  = (float) normalizeDecimal( $indicator[ 'global-initial-measure' ] );
                $ga_last     = (float) normalizeDecimal( $indicator[ 'global-last-measure' ] );

                $post_id = wp_insert_post( $post );

                if ( !empty( $post_id ) ) {
                    wp_set_post_terms( $post_id, $term_slug_component, 'component' );
                    wp_set_post_terms( $post_id, $term_slug_country, 'country' );

                    // Main Fields.
                    update_field( 'short_description_indicator', $indicator[ 'short-description' ], $post_id );
                    update_field( 'indicator_units', $indicator[ 'indicator-units' ], $post_id );
                    update_field( 'period_initial', $indicator[ 'period-initial' ], $post_id );
                    update_field( 'period_recent', $indicator[ 'period-recent' ], $post_id );
                    update_field( 'type_growth_indicator', sanitize_title( $indicator[ 'type-of-growth' ] ), $post_id );

                    // Fields Country.
                    $c_calculated_values = fscp_calculate_group_indicators( $c_initial, $c_last, $indicator[ 'type-of-growth' ] );

                    // Update fields country.
                    update_field( 'country_initial_measure', $c_initial, $post_id );
                    update_field( 'country_last_measure', $c_last, $post_id );
                    update_field( 'country_difference', $c_calculated_values[ 'difference' ], $post_id );
                    update_field( 'country_growth_rate', $c_calculated_values[ 'growth_rate' ], $post_id );
                    update_field( 'country_final_status', $c_calculated_values[ 'final_status' ], $post_id );

                    $country_better_than_world = fscp_country_better_than_world( $c_last, $ga_last, $indicator[ 'type-of-growth' ] );
                    update_field( 'country_better_than_world', $country_better_than_world, $post_id );

                    $c_score_better = better_world_value( $country_better_than_world );
                    update_field( 'country_score_better', $c_score_better, $post_id );

                    $c_comparison_world = fscp_comparison_with_world_average( $country_better_than_world, $c_calculated_values[ 'final_status' ] );
                    update_field( 'country_comparison_with_world', $c_comparison_world, $post_id );

                    // Fields Geographic neighbors.
                    $gn_calculated_values = fscp_calculate_group_indicators( $gn_initial, $gn_last, $indicator[ 'type-of-growth' ] );

                    // Update fields Geographic neighbors.
                    update_field( 'gn_initial_measure', $gn_initial, $post_id );
                    update_field( 'gn_last_measure', $gn_last, $post_id );
                    update_field( 'gn_difference', $gn_calculated_values[ 'difference' ], $post_id );
                    update_field( 'gn_growth_rate', $gn_calculated_values[ 'growth_rate' ], $post_id );
                    update_field( 'gn_final_status', $gn_calculated_values[ 'final_status' ], $post_id );

                    $gn_better_than_world = fscp_country_better_than_world( $gn_last, $ga_last, $indicator[ 'type-of-growth' ] );
                    update_field( 'gn_better_than_world', $gn_better_than_world, $post_id );

                    $gn_score_better = better_world_value( $gn_better_than_world );
                    update_field( 'gn_score_better', $gn_score_better, $post_id );

                    // Fields Countries with similar GDP.
                    $gdp_calculated_values = fscp_calculate_group_indicators( $gdp_initial, $gdp_last, $indicator[ 'type-of-growth' ] );

                    // Update fields Countries with similar GDP.
                    update_field( 'gdp_initial_measure', $gdp_initial, $post_id );
                    update_field( 'gdp_last_measure', $gdp_last, $post_id );
                    update_field( 'gdp_difference', $gdp_calculated_values[ 'difference' ], $post_id );
                    update_field( 'gdp_growth_rate', $gdp_calculated_values[ 'growth_rate' ], $post_id );
                    update_field( 'gdp_final_status', $gdp_calculated_values[ 'final_status' ], $post_id );

                    $gdp_better_than_world = fscp_country_better_than_world( $gdp_last, $ga_last, $indicator[ 'type-of-growth' ] );
                    update_field( 'gdp_better_than_world', $gdp_better_than_world, $post_id );

                    $gdp_score_better = better_world_value( $gdp_better_than_world );
                    update_field( 'gdp_score_better', $gdp_score_better, $post_id );

                    // Fields Global average.
                    $ga_calculated_values = fscp_calculate_group_indicators( $ga_initial, $ga_last, $indicator[ 'type-of-growth' ] );

                    // Update fields Global average.
                    update_field( 'ga_initial_measure', $ga_initial, $post_id );
                    update_field( 'ga_last_measure', $ga_last, $post_id );
                    update_field( 'ga_difference', $ga_calculated_values[ 'difference' ], $post_id );
                    update_field( 'ga_growth_rate', $ga_calculated_values[ 'growth_rate' ], $post_id );
                    update_field( 'ga_final_status', $ga_calculated_values[ 'final_status' ], $post_id );
                    update_field( 'ga_consolidated_value', $ga_calculated_values[ 'consolidated' ], $post_id );
                }
            }
        }

        update_field( 'indicator_country', '', 'sfcs-theme-general-settings' );
        $update_csv = update_field( 'import_csv_indicators', '', 'sfcs-theme-general-settings' );

        if ( $update_csv ) {
            wp_delete_attachment( $fileID, true );
        }
    }
}

add_action( 'acf/save_post', 'wp_import_csv_indicators', 20 );

/**
 * The uploaded file is validated to have no empty data and to have between 25 and 30 items.
 *
 * @param $valid
 * @param $value
 * @param $field
 * @param $input_name
 *
 * @return bool|mixed return message error.
 */
function my_acf_validate_value( $valid, $value, $field, $input_name ) {

    // Bail early if value is already invalid.
    if ( $valid !== true ) {
        return $valid;
    }
    $file_url = wp_get_attachment_url( $value );

    ob_start();
    $handle = fopen( $file_url, 'r' );

    // Importing data from csv.
    while ( ( $data = fgetcsv( $handle, 1000, ";" ) ) !== false ) {
        $rows[] = $data;
    }
    ob_end_clean();
    // Headers are removed.
    unset( $rows[ 0 ] );
    $total = count( $rows );

    // Prevent value from saving if it contains the companies old name.
    if ( $total < 25 || $total > 30 ) {
        return __( 'The file must contain a minimum of 25 and a maximum of 30 indicators.' );
    }

    foreach ( $rows as $key => $value ) {

        foreach ( $value as $k => $val ) {

            if ( $val === '' ) {
                return __( 'There are empty fields and all of them are required.' );
            }
        }
    }

    return $valid;
}

add_filter( 'acf/validate_value/key=field_import_csv_indicators', 'my_acf_validate_value', 10, 4 );
