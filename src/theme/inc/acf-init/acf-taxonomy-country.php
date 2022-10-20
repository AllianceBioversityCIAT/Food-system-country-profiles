<?php
/**
 * This function records fields for the acf.
 */
function register_custom_acf_fields_taxonomy_country() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {
        acf_add_local_field_group( [
                'key'                   => 'group_taxonomy_country',
                'title'                 => 'Taxonomy Country',
                'fields'                => [
                    [
                        'key'               => 'field_634ed6e4ff3bc',
                        'label'             => 'Narrative Page',
                        'name'              => 'narrative_page',
                        'type'              => 'page_link',
                        'instructions'      => '',
                        'required'          => 1,
                        'conditional_logic' => 0,
                        'post_type'         => [
                            0 => 'page',
                        ],
                        'taxonomy'          => '',
                        'allow_null'        => 0,
                        'allow_archives'    => 0,
                        'multiple'          => 0,
                    ],
                    [
                        'key'          => 'field_neighboring_countries_repeater',
                        'name'         => 'neighboring_countries_repeater',
                        'label'        => 'Countries Neighboring',
                        'type'         => 'repeater',
                        'required'     => 1,
                        'min'          => 1,
                        'layout'       => 'table',
                        'button_label' => 'Add country',
                        'sub_fields'   => [
                            [
                                'key'          => 'field_neighboring_country',
                                'label'        => 'Country',
                                'name'         => 'neighboring_country',
                                'type'         => 'text',
                                'instructions' => '',
                                'required'     => 1,
                            ],
                        ],
                    ],
                    [
                        'key'          => 'field_countries_similar_dgp_repeater',
                        'name'         => 'countries_similar_dgp_repeater',
                        'label'        => 'Countries with similar GDP',
                        'type'         => 'repeater',
                        'required'     => 1,
                        'min'          => 1,
                        'layout'       => 'table',
                        'button_label' => 'Add country',
                        'sub_fields'   => [
                            [
                                'key'          => 'field_similar_dgp_country',
                                'label'        => 'Country',
                                'name'         => 'similar_dgp_country',
                                'type'         => 'text',
                                'instructions' => '',
                                'required'     => 1,
                            ],
                        ],
                    ],
                ],
                'location'              => [
                    [
                        [
                            'param'    => 'taxonomy',
                            'operator' => '==',
                            'value'    => 'country',
                        ],
                    ]
                ],
                'menu_order'            => 0,
                'position'              => 'normal',
                'style'                 => 'default',
                'label_placement'       => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen'        => '',
                'active'                => 1,
            ]
        );
    }
}

add_action( 'init', 'register_custom_acf_fields_taxonomy_country' );