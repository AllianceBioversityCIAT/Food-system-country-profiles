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
            'page_title'      => __( 'Create Indicators' ),
            'menu_title'      => __( 'Theme Settings' ),
            'menu_slug'       => 'sfcs-theme-general-settings',
            'capability'      => 'edit_posts',
            'icon_url'        => 'dashicons-admin-settings',
            'redirect'        => false,
            'update_button'   => 'Save options',
            'updated_message' => 'Options saved',
            'post_id'         => 'sfcs-theme-general-settings',
        ) );

        acf_add_options_sub_page( array(
            'page_title'      => __( 'Update Indicators' ),
            'menu_title'      => __( 'Update Indicators' ),
            'menu_slug'       => 'sfcs-update-indicators',
            'capability'      => 'edit_posts',
            'update_button'   => 'Save options',
            'updated_message' => 'Options saved',
            'parent_slug'     => 'sfcs-theme-general-settings',
        ) );
    }
}

add_action( 'acf/init', 'sfcs_acf_op_init' );

function acf_enqueue_admin_script_sfcs( $hook ) {
    if ( 'toplevel_page_sfcs-theme-general-settings' == $hook || 'theme-settings_page_sfcs-update-indicators' == $hook ) {

        wp_enqueue_script( 'acf-settings-page', get_stylesheet_directory_uri() . '/static/js/admin/acf-settings-page.min.js' );
        wp_localize_script( 'acf-settings-page', 'ajax_var', array(
            'url'          => admin_url( 'admin-ajax.php' ),
            'nonce'        => wp_create_nonce( 'sfcs-ajax-nonce' ),
            'fileCreation' => get_stylesheet_directory_uri() . '/static/files/creation-indicators.csv',
        ) );
    }

    return;
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
add_filter( 'acf/load_field/key=field_update_indicator_country', 'acf_load_select_country' );

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
        $term_country      = get_term_by( 'slug', $term_slug_country, 'country' );

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
                $term_component      = get_term_by( 'slug', $term_slug_component, 'component' );
                $post                = [
                    'post_title'  => $indicator[ 'name' ],
                    'post_type'   => 'country-profile',
                    'post_status' => 'publish',
                    'post_author' => get_current_user_id(),
                ];

                $post_id = wp_insert_post( $post );

                if ( !empty( $post_id ) ) {
                    wp_set_post_terms( $post_id, $term_slug_component, 'component' );
                    wp_set_post_terms( $post_id, $term_slug_country, 'country' );

                    // Main Fields.
                    update_field( 'country', $term_country->term_id, $post_id );
                    update_field( 'components', $term_component->term_id, $post_id );
                    update_field( 'short_description_indicator', $indicator[ 'short-description' ], $post_id );
                    update_field( 'indicator_units', $indicator[ 'indicator-units' ], $post_id );
                    update_field( 'period_initial', $indicator[ 'period-initial' ], $post_id );
                    update_field( 'period_recent', $indicator[ 'period-recent' ], $post_id );
                    update_field( 'type_growth_indicator', sanitize_title( $indicator[ 'type-of-growth' ] ), $post_id );

                    updated_fields_indicators( $post_id, $indicator );
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
