<?php
/**
 * This function records fields for the acf.
 */
function register_custom_acf_fields_post_type_country_profile() {

    if ( function_exists( 'acf_add_local_field_group' ) ):
        acf_add_local_field_group( array(
            'key'                   => 'group_62fbea51caa4a',
            'title'                 => 'Fields Country Profile',
            'fields'                => array(
                array(
                    'key'               => 'field_62fbea5df58d0',
                    'label'             => 'Country',
                    'name'              => 'country',
                    'type'              => 'taxonomy',
                    'instructions'      => 'Select country',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ),
                    'taxonomy'          => 'country',
                    'field_type'        => 'select',
                    'allow_null'        => 0,
                    'add_term'          => 0,
                    'save_terms'        => 1,
                    'load_terms'        => 1,
                    'return_format'     => 'object',
                    'multiple'          => 0,
                ),
                array(
                    'key'               => 'field_62fbeb010fe00',
                    'label'             => 'Components',
                    'name'              => 'components',
                    'type'              => 'taxonomy',
                    'instructions'      => 'Select components',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ),
                    'taxonomy'          => 'component',
                    'field_type'        => 'select',
                    'allow_null'        => 0,
                    'add_term'          => 0,
                    'save_terms'        => 1,
                    'load_terms'        => 1,
                    'return_format'     => 'object',
                    'multiple'          => 0,
                ),
                [
                    'key'               => 'field_short_description_indicator',
                    'label'             => 'Short Description',
                    'name'              => 'short_description_indicator',
                    'type'              => 'text',
                    'instructions'      => 'Ej: Proxy for change in Technological Innovations.',
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                    'required'          => 1,
                ],
                [
                    'key'               => 'field_indicator_units',
                    'label'             => 'Indicator units',
                    'name'              => 'indicator_units',
                    'type'              => 'text',
                    'instructions'      => 'Ej: Kg/Ha',
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                    'required'          => 1,
                ],
                [
                    'key'               => 'field_62fbf7b8124c8',
                    'label'             => 'Period Initial',
                    'name'              => 'period_initial',
                    'type'              => 'text',
                    'instructions'      => 'Year of INITIAL data',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                    'default_value'     => '',
                    'placeholder'       => '',
                    'prepend'           => '',
                    'append'            => '',
                    'maxlength'         => '',
                ],
                [
                    'key'               => 'field_62fbf7fd124c9',
                    'label'             => 'Period Recent',
                    'name'              => 'period_recent',
                    'type'              => 'text',
                    'instructions'      => 'Year of RECENT data',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                ],
                [
                    'key'           => 'field_type_growth_indicator',
                    'label'         => 'Type of Growth',
                    'name'          => 'type_growth_indicator',
                    'type'          => 'select',
                    'instructions'  => '',
                    'required'      => 1,
                    'wrapper'       => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                    'choices'       => [
                        'normal'   => 'Normal',
                        'inverted' => 'Inverted'
                    ],
                    'default_value' => 'normal',
                    'return_format' => 'array',
                ],
                [
                    'key'               => 'field_62fbec2bbbf43',
                    'label'             => 'Country Data',
                    'name'              => '',
                    'type'              => 'tab',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'placement'         => 'top',
                    'endpoint'          => 0,
                ],
                [
                    'key'               => 'field_62fbecdabbf44',
                    'label'             => 'Initial Measure',
                    'name'              => 'country_initial_measure',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_62fbed02bbf45',
                    'label'             => 'Last Measure',
                    'name'              => 'country_last_measure',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_country_difference',
                    'label'             => 'Difference',
                    'name'              => 'country_difference',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                    'default_value'     => '',
                    'placeholder'       => '',
                    'prepend'           => '',
                    'append'            => '',
                    'maxlength'         => '',
                ],
                [
                    'key'               => 'field_country_growth_rate',
                    'label'             => 'Growth Rate %',
                    'name'              => 'country_growth_rate',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                ],
                [
                    'key'               => 'field_country_final_status',
                    'label'             => 'Final Status',
                    'name'              => 'country_final_status',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                ],
                [
                    'key'               => 'field_country_score_better',
                    'label'             => 'Score Better',
                    'name'              => 'country_score_better',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                    'default_value' => '0',
                    'min'               => '-1',
                    'max'               => '0',
                ],
                [
                    'key'               => 'field_country_better_than_world',
                    'label'             => 'Country better than world',
                    'name'              => 'country_better_than_world',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                ],
                [
                    'key'               => 'field_country_comparison_with_world',
                    'label'             => 'Comparison with World average',
                    'name'              => 'country_comparison_with_world',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                ],
                array(
                    'key'               => 'field_62fbee19badd0',
                    'label'             => 'Countries with similar GDP',
                    'name'              => '',
                    'type'              => 'tab',
                    'instructions'      => '',
                    'required'          => 0,
                ),
                array(
                    'key'               => 'field_62fbee30badd1',
                    'label'             => 'Initial Measure',
                    'name'              => 'gdp_initial_measure',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key'               => 'field_62fbee56badd2',
                    'label'             => 'Last Measure',
                    'name'              => 'gdp_last_measure',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '50',
                    ),
                ),
                [
                    'key'               => 'field_gdp_difference',
                    'label'             => 'Difference',
                    'name'              => 'gdp_difference',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_gdp_growth_rate',
                    'label'             => 'Growth Rate %',
                    'name'              => 'gdp_growth_rate',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_gdp_final_status',
                    'label'             => 'Final Status',
                    'name'              => 'gdp_final_status',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_gdp_consolidated_value',
                    'label'             => 'Consolidated Value',
                    'name'              => 'gdp_consolidated_value',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                    'min'               => '-1',
                    'max'               => '0',
                ],
                array(
                    'key'               => 'field_62fbed223174a',
                    'label'             => 'Geographic Neighbors',
                    'name'              => '',
                    'type'              => 'tab',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                ),
                array(
                    'key'               => 'field_62fbed5b85f55',
                    'label'             => 'Initial Measure',
                    'name'              => 'gn_initial_measure',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key'               => 'field_62fbed84e9d68',
                    'label'             => 'Last Measure',
                    'name'              => 'gn_last_measure',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '50',
                    ),
                ),
                [
                    'key'               => 'field_gn_difference',
                    'label'             => 'Difference',
                    'name'              => 'gn_difference',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_gn_growth_rate',
                    'label'             => 'Growth Rate %',
                    'name'              => 'gn_growth_rate',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_gn_final_status',
                    'label'             => 'Final Status',
                    'name'              => 'gn_final_status',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_gn_consolidated_value',
                    'label'             => 'Consolidated Value',
                    'name'              => 'gn_consolidated_value',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                        'class' => '',
                        'id'    => '',
                    ],
                    'min'               => '-1',
                    'max'               => '0',
                ],
                array(
                    'key'               => 'field_62fbeef0a5f66',
                    'label'             => 'Global average',
                    'name'              => '',
                    'type'              => 'tab',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                ),
                array(
                    'key'               => 'field_62fbef04a5f67',
                    'label'             => 'Initial Measure',
                    'name'              => 'ga_initial_measure',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '50',
                    ),
                ),
                array(
                    'key'               => 'field_62fbef0fa5f68',
                    'label'             => 'Last Measure',
                    'name'              => 'ga_last_measure',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 1,
                    'conditional_logic' => 0,
                    'wrapper'           => array(
                        'width' => '50',
                    ),
                ),
                [
                    'key'               => 'field_ga_difference',
                    'label'             => 'Difference',
                    'name'              => 'ga_difference',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_ga_growth_rate',
                    'label'             => 'Growth Rate %',
                    'name'              => 'ga_growth_rate',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_ga_final_status',
                    'label'             => 'Final Status',
                    'name'              => 'ga_final_status',
                    'type'              => 'text',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                ],
                [
                    'key'               => 'field_ga_consolidated_value',
                    'label'             => 'Consolidated Value',
                    'name'              => 'ga_consolidated_value',
                    'type'              => 'number',
                    'instructions'      => '',
                    'required'          => 0,
                    'conditional_logic' => 0,
                    'wrapper'           => [
                        'width' => '50',
                    ],
                    'min'               => '-1',
                    'max'               => '0',
                ],
            ),
            'location'              => array(
                array(
                    array(
                        'param'    => 'post_type',
                        'operator' => '==',
                        'value'    => 'country-profile',
                    ),
                ),
            ),
            'menu_order'            => 0,
            'position'              => 'normal',
            'style'                 => 'default',
            'label_placement'       => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen'        => '',
            'active'                => true,
            'description'           => '',
            'show_in_rest'          => 0,
        ) );

    endif;
}

add_action( 'init', 'register_custom_acf_fields_post_type_country_profile' );
