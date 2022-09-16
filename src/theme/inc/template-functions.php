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
