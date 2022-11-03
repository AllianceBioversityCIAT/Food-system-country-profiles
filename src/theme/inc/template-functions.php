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
                'country' => ucfirst( $get_country ),
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

        $screen  = get_current_screen();
        $cpt     = ( !empty( $screen->post_type ) ) ? $screen->post_type : $screen->id;
        $path    = get_theme_file_path();
        $js_name = "/static/js/admin/admin-$cpt.min.js";

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
            $c_calculated_values = fscp_calculate_group_indicators( $fields[ 'country_initial_measure' ], $fields[ 'country_last_measure' ], $fields[ 'type_growth_indicator' ][ 'value' ] );

            // Update fields country.
            update_field( 'country_difference', $c_calculated_values[ 'difference' ], $post_id );
            update_field( 'country_growth_rate', $c_calculated_values[ 'growth_rate' ], $post_id );
            update_field( 'country_final_status', $c_calculated_values[ 'final_status' ], $post_id );

            $country_better_than_world = fscp_country_better_than_world( $fields[ 'country_last_measure' ], $fields[ 'ga_last_measure' ], $fields[ 'type_growth_indicator' ][ 'value' ] );
            update_field( 'country_better_than_world', $country_better_than_world, $post_id );

            $c_score_better = better_world_value( $country_better_than_world );
            update_field( 'country_score_better', $c_score_better, $post_id );

            $c_comparison_world = fscp_comparison_with_world_average( $country_better_than_world, $c_calculated_values[ 'final_status' ] );
            update_field( 'country_comparison_with_world', $c_comparison_world, $post_id );

            // Fields Geographic neighbors.
            $gn_calculated_values = fscp_calculate_group_indicators( $fields[ 'gn_initial_measure' ], $fields[ 'gn_last_measure' ], $fields[ 'type_growth_indicator' ][ 'value' ] );

            // Update fields Geographic neighbors.
            update_field( 'gn_difference', $gn_calculated_values[ 'difference' ], $post_id );
            update_field( 'gn_growth_rate', $gn_calculated_values[ 'growth_rate' ], $post_id );
            update_field( 'gn_final_status', $gn_calculated_values[ 'final_status' ], $post_id );

            $gn_better_than_world = fscp_country_better_than_world( $fields[ 'gn_last_measure' ], $fields[ 'ga_last_measure' ], $fields[ 'type_growth_indicator' ][ 'value' ] );
            update_field( 'gn_better_than_world', $gn_better_than_world, $post_id );

            $gn_score_better = better_world_value( $gn_better_than_world );
            update_field( 'gn_score_better', $gn_score_better, $post_id );

            // Fields Countries with similar GDP.
            $gdp_calculated_values = fscp_calculate_group_indicators( $fields[ 'gdp_initial_measure' ], $fields[ 'gdp_last_measure' ], $fields[ 'type_growth_indicator' ][ 'value' ] );

            // Update fields Countries with similar GDP.
            update_field( 'gdp_difference', $gdp_calculated_values[ 'difference' ], $post_id );
            update_field( 'gdp_growth_rate', $gdp_calculated_values[ 'growth_rate' ], $post_id );
            update_field( 'gdp_final_status', $gdp_calculated_values[ 'final_status' ], $post_id );

            $gdp_better_than_world = fscp_country_better_than_world( $fields[ 'gdp_last_measure' ], $fields[ 'ga_last_measure' ], $fields[ 'type_growth_indicator' ][ 'value' ] );
            update_field( 'gdp_better_than_world', $gdp_better_than_world, $post_id );

            $gdp_score_better = better_world_value( $gdp_better_than_world );
            update_field( 'gdp_score_better', $gdp_score_better, $post_id );

            // Fields Global average.
            $ga_calculated_values = fscp_calculate_group_indicators( $fields[ 'ga_initial_measure' ], $fields[ 'ga_last_measure' ], $fields[ 'type_growth_indicator' ][ 'value' ] );

            // Update fields Global average.
            update_field( 'ga_difference', $ga_calculated_values[ 'difference' ], $post_id );
            update_field( 'ga_growth_rate', $ga_calculated_values[ 'growth_rate' ], $post_id );
            update_field( 'ga_final_status', $ga_calculated_values[ 'final_status' ], $post_id );
            update_field( 'ga_consolidated_value', $ga_calculated_values[ 'consolidated' ], $post_id );
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

function better_world_value( $better_than_world ) {

    if ( $better_than_world === 'false' ) {
        return -1;
    }

    return 0;
}

/**
 * Display a custom taxonomy dropdown in admin.
 */
function fscp_filter_cars_by_taxonomies( $post_type, $which ) {

    // Apply this only on a specific post type
    if ( 'country-profile' !== $post_type )
        return;

    // A list of taxonomy slugs to filter by
    $taxonomies = [ 'country', 'component' ];

    foreach ( $taxonomies as $taxonomy_slug ) {

        // Retrieve taxonomy data
        $taxonomy_obj  = get_taxonomy( $taxonomy_slug );
        $taxonomy_name = $taxonomy_obj->labels->name;

        // Retrieve taxonomy terms
        $terms = get_terms( $taxonomy_slug );

        // Display filter HTML
        echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
        echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
        foreach ( $terms as $term ) {
            printf(
                '<option value="%1$s" %2$s>%3$s</option>',
                $term->slug,
                ( ( isset( $_GET[ $taxonomy_slug ] ) && ( $_GET[ $taxonomy_slug ] == $term->slug ) ) ? ' selected="selected"' : '' ),
                $term->name,
                $term->count
            );
        }
        echo '</select>';
    }

}

add_action( 'restrict_manage_posts', 'fscp_filter_cars_by_taxonomies', 10, 2 );

function fscp_calculate_group_indicators( $initial_measure, $last_measure, $type_growth ) {
    $calculate_result = [ 'difference' => 0, 'growth_rate' => 0, 'final_status' => 0, 'consolidated' => 0, 'score_indicator' => '' ];

    if ( $last_measure == 0 && $initial_measure == 0 ) {
        $calculate_result[ 'difference' ]   = 0;
        $calculate_result[ 'growth_rate' ]  = 0;
        $calculate_result[ 'final_status' ] = final_status_growth( $calculate_result[ 'growth_rate' ], $type_growth );
        $calculate_result[ 'consolidated' ] = consolidated_value( $calculate_result[ 'final_status' ] );

    } else if ( $initial_measure == 0 ) {
        $calculate_result[ 'difference' ]   = 0;
        $calculate_result[ 'growth_rate' ]  = 0;
        $calculate_result[ 'final_status' ] = final_status_growth( $calculate_result[ 'growth_rate' ], $type_growth );
        $calculate_result[ 'consolidated' ] = consolidated_value( $calculate_result[ 'final_status' ] );

    } else {
        $calculate_result[ 'difference' ]   = (float) $last_measure - $initial_measure;
        $calculate_result[ 'growth_rate' ]  = round( (float) ( $calculate_result[ 'difference' ] / $initial_measure ) * 100, 2 );
        $calculate_result[ 'final_status' ] = final_status_growth( $calculate_result[ 'growth_rate' ], $type_growth );
        $calculate_result[ 'consolidated' ] = consolidated_value( $calculate_result[ 'final_status' ] );
    }

    return $calculate_result;
}

function fscp_calculate_component_value( $component, $count ) {
    $component_result = [ 'c' => $count, 'gn' => $count, 'gdp' => $count, 'ga' => $count, 'total_component' => $count ];

    foreach ( $component as $value ) {
        $component_result[ 'c' ]   = $component_result[ 'c' ] + ( $value->custom[ 'country_score_better' ] );
        $component_result[ 'gn' ]  = $component_result[ 'gn' ] + ( $value->custom[ 'gn_score_better' ] );
        $component_result[ 'gdp' ] = $component_result[ 'gdp' ] + ( $value->custom[ 'gdp_score_better' ] );
        $component_result[ 'ga' ]  = $component_result[ 'ga' ] + ( $value->custom[ 'ga_consolidated_value' ] );

    }
    return $component_result;
}

/**
 * Used to perform custom validation on the field’s $value before it is saved into the database.
 *
 * @param $valid (mixed) Whether or not the value is valid (boolean) or a custom error message (string).
 * @param $value (mixed) The field value.
 * @param $field (array) The field array containing all settings.
 * @param $input (string) The field DOM element name attribute.
 *
 * @return mixed Get the text valid.
 */
function fscp_acf_validate_value_number( $valid, $value, $field, $input ) {

    if ( !preg_match( '/^(?!-0(\.0+)?$)-?(0|[1-9]\d*)(\.\d+)?$/', $value ) ) {
        $valid = __( 'Only numbers are allowed in this field.' );
    }

    // return
    return $valid;
}

add_filter( 'acf/validate_value/type=number', 'fscp_acf_validate_value_number', 10, 4 );

function fscp_country_better_than_world( $c_last_measure, $ga_last_measure, $type_growth ) {

    if ( ( ( $type_growth === 'normal' ) && ( $c_last_measure >= $ga_last_measure ) ) || ( ( $type_growth === 'inverted' ) && ( $c_last_measure <= $ga_last_measure ) ) ) {
        return 'true';
    }

    return 'false';
}

function fscp_comparison_with_world_average( $country_better, $c_final_status ) {

    if ( ( $c_final_status === 'improve' && $country_better === 'true' ) || ( $c_final_status === 'unchanged' && $country_better === 'true' ) ) {
        return 'and doing better than the World Average';

    } else if ( ( $c_final_status === 'improve' && $country_better === 'false' ) || ( $c_final_status === 'unchanged' && $country_better === 'false' ) ) {
        return 'but doing worse than the World Average';

    } else if ( $c_final_status === 'deteriorate' && $country_better === 'true' ) {
        return 'but doing better than the World Average';

    } else if ( $c_final_status === 'deteriorate' && $country_better === 'false' ) {
        return 'and doing worse than the World Average';
    }

    return;
}
