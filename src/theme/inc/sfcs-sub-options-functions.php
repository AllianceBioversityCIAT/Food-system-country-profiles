<?php

function create_csv_all_indicators_from_country() {

    // Verify nonce
    if ( !isset( $_POST[ 'nonce' ] ) || !wp_verify_nonce( $_POST[ 'nonce' ], 'sfcs-ajax-nonce' ) ) {
        die( 'Permission denied' );
    }
    $data           = [];
    $select_country = sanitize_text_field( $_POST[ 'country' ] );

    $arg_indicators = [
        'post_type'      => 'country-profile',
        'posts_per_page' => -1,
        'tax_query'      => [
            [
                'taxonomy' => 'country',
                'field'    => 'slug',
                'terms'    => $select_country,
            ],
        ],
    ];

    $posts  = get_posts( $arg_indicators );
    $data[] = [
        0  => 'id-indicator',
        1  => 'name',
        2  => 'country',
        3  => 'component',
        4  => 'short-description',
        5  => 'indicator-units',
        6  => 'period-initial',
        7  => 'period-recent',
        8  => 'type-of-growth',
        9  => 'country-initial-measure',
        10 => 'country-last-measure',
        11 => 'gdp-initial-measure',
        12 => 'gdp-last-measure',
        13 => 'neighbors-initial-measure',
        14 => 'neighbors-last-measure',
        15 => 'global-initial-measure',
        16 => 'global-last-measure',
    ];
    foreach ( $posts as $post ) {
        $fields = get_fields( $post->ID );
        $data[] = [
            $post->ID,
            $post->post_title,
            $fields[ 'country' ]->slug,
            $fields[ 'components' ]->slug,
            $fields[ 'short_description_indicator' ],
            $fields[ 'indicator_units' ],
            $fields[ 'period_initial' ],
            $fields[ 'period_recent' ],
            $fields[ 'type_growth_indicator' ][ 'value' ],
            $fields[ 'country_initial_measure' ],
            $fields[ 'country_last_measure' ],
            $fields[ 'gdp_initial_measure' ],
            $fields[ 'gdp_last_measure' ],
            $fields[ 'gn_initial_measure' ],
            $fields[ 'gn_last_measure' ],
            $fields[ 'ga_initial_measure' ],
            $fields[ 'ga_last_measure' ],
        ];
    }

    return wp_send_json( $data );
}

add_action( 'wp_ajax_create_csv_all_indicators_from_country', 'create_csv_all_indicators_from_country' );

/**
 * This function gets the country and the csv to create the indicators.
 */
function wp_import_csv_update_indicators() {
    $screen = get_current_screen();
    $data_post   = $_POST;

    if ( 'theme-settings_page_sfcs-update-indicators' === $screen->id ) {
        $head_array = [
            0  => 'id-indicator',
            1  => 'name',
            2  => 'country',
            3  => 'component',
            4  => 'short-description',
            5  => 'indicator-units',
            6  => 'period-initial',
            7  => 'period-recent',
            8  => 'type-of-growth',
            9  => 'country-initial-measure',
            10 => 'country-last-measure',
            11 => 'gdp-initial-measure',
            12 => 'gdp-last-measure',
            13 => 'neighbors-initial-measure',
            14 => 'neighbors-last-measure',
            15 => 'global-initial-measure',
            16 => 'global-last-measure',
        ];

        $fileID     = $data_post[ 'acf' ][ 'field_update_csv_indicators' ];
        $rows       = [];
        $ind        = [];
        $indicators = [];

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
                $post_id = $indicator[ 'id-indicator' ];

                if ( !empty( $post_id ) ) {

                    // Update post title.
                    $post_update = [
                        'ID'         => $post_id,
                        'post_title' => $indicator[ 'name' ]
                    ];
                    wp_update_post( $post_update );

                    // Update country field.
                    $term_slug_country = $indicator[ 'country' ];
                    $term_country      = get_term_by( 'slug', $term_slug_country, 'country' );
                    wp_set_post_terms( $post_id, $term_slug_country, 'country' );
                    update_field( 'country', $term_country->term_id, $post_id );

                    // Update component field.
                    $term_slug_component = $indicator[ 'component' ];
                    $term_component      = get_term_by( 'slug', $term_slug_component, 'component' );
                    wp_set_post_terms( $post_id, $term_slug_component, 'component' );
                    update_field( 'components', $term_component->term_id, $post_id );

                    // Main Fields.
                    update_field( 'short_description_indicator', $indicator[ 'short-description' ], $post_id );
                    update_field( 'indicator_units', $indicator[ 'indicator-units' ], $post_id );
                    update_field( 'period_initial', $indicator[ 'period-initial' ], $post_id );
                    update_field( 'period_recent', $indicator[ 'period-recent' ], $post_id );
                    update_field( 'type_growth_indicator', sanitize_title( $indicator[ 'type-of-growth' ] ), $post_id );

                    updated_fields_indicators( $post_id, $indicator );
                }
            }
        }

        $update_csv = update_field( 'update_csv_indicators', '', 'sfcs-update-indicators' );

        if ( $update_csv ) {
            wp_delete_attachment( $fileID, true );
        }

    }
}

add_action( 'acf/save_post', 'wp_import_csv_update_indicators', 20 );

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
function update_csv_validate_value( $valid, $value, $field, $input_name ) {

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

    foreach ( $rows as $key => $value ) {

        foreach ( $value as $k => $val ) {

            if ( $val === '' ) {
                return __( 'There are empty fields and all of them are required.' );
            }
        }
    }

    return $valid;
}

add_filter( 'acf/validate_value/key=field_update_csv_indicators', 'update_csv_validate_value', 10, 4 );

function updated_fields_indicators( $post_id, $indicator ) {

    // Converting calculation variables to float.
    $c_initial   = (float) normalizeDecimal( $indicator[ 'country-initial-measure' ] );
    $c_last      = (float) normalizeDecimal( $indicator[ 'country-last-measure' ] );
    $gn_initial  = (float) normalizeDecimal( $indicator[ 'neighbors-initial-measure' ] );
    $gn_last     = (float) normalizeDecimal( $indicator[ 'neighbors-last-measure' ] );
    $gdp_initial = (float) normalizeDecimal( $indicator[ 'gdp-initial-measure' ] );
    $gdp_last    = (float) normalizeDecimal( $indicator[ 'gdp-last-measure' ] );
    $ga_initial  = (float) normalizeDecimal( $indicator[ 'global-initial-measure' ] );
    $ga_last     = (float) normalizeDecimal( $indicator[ 'global-last-measure' ] );

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
