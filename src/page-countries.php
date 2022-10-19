<?php
/**
 * Template Name: Country Narrative page
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}
get_header();

while ( have_posts() ) :
    the_post();
    ?>

    <main id="content" <?php post_class( 'site-main' ); ?> role="main">
        <div class="page-content">
            <?php the_content(); ?>
            <div class="post-tags">
                <?php the_tags( '<span class="tag-links">' . __( 'Tagged ', 'hello-elementor' ), null, '</span>' ); ?>
            </div>
            <?php wp_link_pages(); ?>
        </div>

        <?php comments_template(); ?>
    </main>

<?php
endwhile;

get_footer();
