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

    $posts      = get_posts( $arg_indicators );
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
