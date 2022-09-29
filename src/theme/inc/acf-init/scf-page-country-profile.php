<?php
/**
 * This function records fields for the acf.
 */
function register_custom_acf_fields_page_country_profile() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {
        acf_add_local_field_group( [
                'key'                   => 'group_page_country_profile',
                'title'                 => 'Dashboard configuration',
                'fields'                => [
                    [
                        'key'          => 'field_note_description_indicator',
                        'label'        => 'Indicator Note',
                        'name'         => 'note_description_indicator',
                        'type'         => 'text',
                        'instructions' => 'Note for the explanation of country indicators.',
                        'required'     => 1,
                    ],
                ],
                'location'              => [
                    [
                        [
                            'param'    => 'post_template',
                            'operator' => '==',
                            'value'    => 'page-dashboard.php',
                        ],
                    ]
                ],
                'menu_order'            => 0,
                'position'              => 'acf_after_title',
                'style'                 => 'default',
                'label_placement'       => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen'        => '',
                'active'                => true,
                'show_in_rest'          => 1,
            ]
        );
    }
}

add_action( 'init', 'register_custom_acf_fields_page_country_profile' );
