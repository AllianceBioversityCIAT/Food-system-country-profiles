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

    $context                = Timber::context();
    $context[ 'post' ]      = new Timber\Post();
    $context[ 'country' ]   = $get_country;
    $context[ 'countries' ] = $countries_terms;
    $context[ 'note' ]      = get_field( 'note_description_indicator', $page_ID );

    Timber::render( './view/page-dashboard.twig', $context );

} else {
    echo '<h1>Timber plugin is required</h1>';
}

get_footer();
