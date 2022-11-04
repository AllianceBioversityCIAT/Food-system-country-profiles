<?php
/**
 * This function records fields for the acf.
 */
function register_custom_acf_fields_template_dashboard() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {
        acf_add_local_field_group( [
                'key'                   => 'group_template_dashboard',
                'title'                 => 'Dashboard',
                'fields'                => [
                    //Driver Component.
                    [
                        'key'          => 'field_dash_driver_title_text',
                        'label'        => 'Driver Title',
                        'name'         => 'dash_driver_title_text',
                        'type'         => 'text',
                        'instructions' => '',
                        'required'     => 1,
                        'wrapper'      => [
                            'width' => '50',
                            'class' => '',
                            'id'    => '',
                        ],
                    ],
                    [
                        'key'          => 'field_dash_driver_description',
                        'label'        => 'Driver Description',
                        'name'         => 'dash_driver_description',
                        'aria-label'   => '',
                        'type'         => 'textarea',
                        'instructions' => '',
                        'required'     => 1,
                        'wrapper'      => [
                            'width' => '50',
                            'class' => '',
                            'id'    => '',
                        ],
                        'rows'         => 2,
                    ],
                    // Actors and activities component.
                    [
                        'key'          => 'field_dash_actors_title_text',
                        'label'        => 'Actors Title',
                        'name'         => 'dash_actors_title_text',
                        'type'         => 'text',
                        'instructions' => '',
                        'required'     => 1,
                        'wrapper'      => [
                            'width' => '50',
                            'class' => '',
                            'id'    => '',
                        ],
                    ],
                    [
                        'key'          => 'field_dash_actors_description',
                        'label'        => 'Actors Description',
                        'name'         => 'dash_actors_description',
                        'aria-label'   => '',
                        'type'         => 'textarea',
                        'instructions' => '',
                        'required'     => 1,
                        'wrapper'      => [
                            'width' => '50',
                            'class' => '',
                            'id'    => '',
                        ],
                        'rows'         => 2,
                    ],
                    // Food environment component.
                    [
                        'key'          => 'field_dash_environment_title_text',
                        'label'        => 'Environment Title',
                        'name'         => 'dash_environment_title_text',
                        'type'         => 'text',
                        'instructions' => '',
                        'required'     => 1,
                        'wrapper'      => [
                            'width' => '50',
                            'class' => '',
                            'id'    => '',
                        ],
                    ],
                    [
                        'key'          => 'field_dash_environment_description',
                        'label'        => 'Environment Description',
                        'name'         => 'dash_environment_description',
                        'aria-label'   => '',
                        'type'         => 'textarea',
                        'instructions' => '',
                        'required'     => 1,
                        'wrapper'      => [
                            'width' => '50',
                            'class' => '',
                            'id'    => '',
                        ],
                        'rows'         => 2,
                    ],
                    // Consumer behavior component.
                    [
                        'key'          => 'field_dash_behavior_title_text',
                        'label'        => 'Behavior Title',
                        'name'         => 'dash_behavior_title_text',
                        'type'         => 'text',
                        'instructions' => '',
                        'required'     => 1,
                        'wrapper'      => [
                            'width' => '50',
                            'class' => '',
                            'id'    => '',
                        ],
                    ],
                    [
                        'key'          => 'field_dash_behavior_description',
                        'label'        => 'Behavior Description',
                        'name'         => 'dash_behavior_description',
                        'aria-label'   => '',
                        'type'         => 'textarea',
                        'instructions' => '',
                        'required'     => 1,
                        'wrapper'      => [
                            'width' => '50',
                            'class' => '',
                            'id'    => '',
                        ],
                        'rows'         => 2,
                    ],
                    // Outcomes component.
                    [
                        'key'          => 'field_dash_outcomes_title_text',
                        'label'        => 'Outcomes Title',
                        'name'         => 'dash_outcomes_title_text',
                        'type'         => 'text',
                        'instructions' => '',
                        'required'     => 1,
                        'wrapper'      => [
                            'width' => '50',
                            'class' => '',
                            'id'    => '',
                        ],
                    ],
                    [
                        'key'          => 'field_dash_outcomes_description',
                        'label'        => 'Outcomes Description',
                        'name'         => 'dash_outcomes_description',
                        'aria-label'   => '',
                        'type'         => 'textarea',
                        'instructions' => '',
                        'required'     => 1,
                        'wrapper'      => [
                            'width' => '50',
                            'class' => '',
                            'id'    => '',
                        ],
                        'rows'         => 2,
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
                'hide_on_screen'        => [
                    0 => 'the_content',
                ],
                'active'                => true,
                'show_in_rest'          => 1,
            ]
        );
    }
}

add_action( 'init', 'register_custom_acf_fields_template_dashboard' );
