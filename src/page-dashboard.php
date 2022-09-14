<?php
/**
 * Template Name: Dashboard Country Profile
 */

get_header();

if ( class_exists( 'Timber' ) ) {
    $context           = Timber::context();
    $context[ 'post' ] = new Timber\Post();

    Timber::render( './view/page-dashboard.twig', $context );
} else {
    echo '<h1>Timber plugin is required</h1>';
}

get_footer();
