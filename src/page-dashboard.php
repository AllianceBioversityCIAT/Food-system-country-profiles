<?php
/**
 * Template Name: Dashboard Country Profile
 */

get_header();

if ( class_exists( 'Timber' ) ) {
    $page_ID         = get_the_ID();
    $countries_terms = get_terms( array(
        'taxonomy'   => 'country',
        'hide_empty' => false,
    ) );
    $get_country     = ( isset( $_GET[ 'country' ] ) ) ? sanitize_text_field( $_GET[ 'country' ] ) : '';

    $arg_indicator_driven = [
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

    $arg_indicator_actors = [
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

    $arg_indicator_food = [
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
                'terms'    => 'consumer-behavior',
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

    Timber::render( './view/page-dashboard.twig', $context );

} else {
    echo '<h1>Timber plugin is required</h1>';
}

get_footer();
