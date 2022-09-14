<?php
/**
 * This function records fields for the acf.
 */
function register_custom_acf_fields_user() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {
        acf_add_local_field_group( [
                'key'                   => 'group_post_type_post',
                'title'                 => 'Page Test',
                'fields'                => [
                    [
                        'key'          => 'field_post_teams',
                        'label'        => 'Teams',
                        'name'         => 'post_teams',
                        'type'         => 'text',
                        'instructions' => '',
                        'required'     => 0,
                        'maxlength'    => 40,
                    ],
                ],
                'location'              => [
                    [
                        [
                            'param'    => 'post_type',
                            'operator' => '==',
                            'value'    => 'post',
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

add_action( 'init', 'register_custom_acf_fields_user' );
