<?php
/**
 * Template Name: Dashboard Country Profile
 */

get_header();

if ( class_exists( 'Timber' ) ) {
    $page_ID                = get_the_ID();
    $countries_terms        = get_terms( array(
        'taxonomy'   => 'country',
        'hide_empty' => true,
    ) );
    $get_country            = ( isset( $_GET[ 'country' ] ) ) ? sanitize_text_field( $_GET[ 'country' ] ) : '';
    $country_term           = get_term_by( 'slug', $get_country, 'country' );
    $arg_indicator_driven   = [
        'post_type'      => 'country-profile',
        'posts_per_page' => -1,
        'tax_query'      => [
            'relation' => 'AND',
            [
                'taxonomy' => 'country',
                'field'    => 'slug',
                'terms'    => $get_country,
            ],
            [
                'taxonomy' => 'component',
                'field'    => 'slug',
                'terms'    => 'drivers',
            ],
        ],
    ];
    $arg_indicator_actors   = [
        'post_type'      => 'country-profile',
        'posts_per_page' => -1,
        'tax_query'      => [
            'relation' => 'AND',
            [
                'taxonomy' => 'country',
                'field'    => 'slug',
                'terms'    => $get_country,
            ],
            [
                'taxonomy' => 'component',
                'field'    => 'slug',
                'terms'    => 'actors-and-activities',
            ],
        ],
    ];
    $arg_indicator_food     = [
        'post_type'      => 'country-profile',
        'posts_per_page' => -1,
        'tax_query'      => [
            'relation' => 'AND',
            [
                'taxonomy' => 'country',
                'field'    => 'slug',
                'terms'    => $get_country,
            ],
            [
                'taxonomy' => 'component',
                'field'    => 'slug',
                'terms'    => 'food-environment',
            ],
        ],
    ];
    $arg_indicator_consumer = [
        'post_type'      => 'country-profile',
        'posts_per_page' => -1,
        'tax_query'      => [
            'relation' => 'AND',
            [
                'taxonomy' => 'country',
                'field'    => 'slug',
                'terms'    => $get_country,
            ],
            [
                'taxonomy' => 'component',
                'field'    => 'slug',
                'terms'    => 'consumer-behavior',
            ],
        ],
    ];
    $arg_indicator_outcomes = [
        'post_type'      => 'country-profile',
        'posts_per_page' => -1,
        'tax_query'      => [
            'relation' => 'AND',
            [
                'taxonomy' => 'country',
                'field'    => 'slug',
                'terms'    => $get_country,
            ],
            [
                'taxonomy' => 'component',
                'field'    => 'slug',
                'terms'    => 'outcomes',
            ],
        ],
    ];

    $context                        = Timber::context();
    $context[ 'post' ]              = new Timber\Post();
    $context[ 'country' ]           = $get_country;
    $context[ 'countries' ]         = $countries_terms;
    $context[ 'note' ]              = get_field( 'note_description_indicator', $page_ID );
    $context[ 'indicatorDrivers' ]  = Timber::get_posts( $arg_indicator_driven );
    $context[ 'indicatorActors' ]   = Timber::get_posts( $arg_indicator_actors );
    $context[ 'indicatorFood' ]     = Timber::get_posts( $arg_indicator_food );
    $context[ 'indicatorConsumer' ] = Timber::get_posts( $arg_indicator_consumer );
    $context[ 'indicatorOutcomes' ] = Timber::get_posts( $arg_indicator_outcomes );

    $context[ 'componentDrivers' ]  = fscp_calculate_component_value( $context[ 'indicatorDrivers' ], count( $context[ 'indicatorDrivers' ] ) );
    $context[ 'componentActors' ]   = fscp_calculate_component_value( $context[ 'indicatorActors' ], count( $context[ 'indicatorActors' ] ) );
    $context[ 'componentFood' ]     = fscp_calculate_component_value( $context[ 'indicatorFood' ], count( $context[ 'indicatorFood' ] ) );
    $context[ 'componentConsumer' ] = fscp_calculate_component_value( $context[ 'indicatorConsumer' ], count( $context[ 'indicatorConsumer' ] ) );
    $context[ 'componentOutcomes' ] = fscp_calculate_component_value( $context[ 'indicatorOutcomes' ], count( $context[ 'indicatorOutcomes' ] ) );

    if ( $country_term ) {
        $context[ 'countryFields' ] = get_fields( 'country_' . $country_term->term_id );
    }

    Timber::render( './view/page-dashboard.twig', $context );

} else {
    echo '<h1>Timber plugin is required</h1>';
}

get_footer();
