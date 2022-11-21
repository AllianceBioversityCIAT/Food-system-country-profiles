<?php
/**
 * This function records fields for the acf.
 */
function register_custom_acf_fields_sub_settings_page() {

    if ( function_exists( 'acf_add_local_field_group' ) ) {
        $log_download_update_indicators = '<div id="content-download-csv-update"></div>';

        acf_add_local_field_group(
            [
                'key'                   => 'group_sfcs_settings_sub_page',
                'title'                 => 'Update',
                'fields'                => [
                    [
                        'key'               => 'field_update_indicators_tab_1',
                        'label'             => 'Update indicators',
                        'name'              => '',
                        'type'              => 'tab',
                        'instructions'      => '',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'placement'         => 'top',
                        'endpoint'          => 1,
                    ],
                    [
                        'key'               => 'field_download_update_indicators',
                        'name'              => 'download_update_indicators',
                        'type'              => 'message',
                        'instructions'      => '',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'message'           => $log_download_update_indicators,
                        'esc_html'          => 0,
                        'wrapper'           => [
                            'width' => '50',
                            'class' => '',
                            'id'    => 'download-update-indicators',
                        ],
                    ],
                    [
                        'key'               => 'field_update_indicator_country',
                        'label'             => 'Indicator Country',
                        'name'              => 'update_indicator_country',
                        'aria-label'        => '',
                        'type'              => 'select',
                        'instructions'      => '',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'wrapper'           => [
                            'width' => '50',
                        ],
                        'choices'           => array(),
                        'default_value'     => false,
                        'return_format'     => 'value',
                        'multiple'          => 0,
                        'allow_null'        => 1,
                        'ui'                => 0,
                        'ajax'              => 0,
                        'placeholder'       => '',
                    ],
                    [
                        'key'               => 'field_update_csv_indicators',
                        'label'             => 'Import CSV',
                        'name'              => 'update_csv_indicators',
                        'aria-label'        => '',
                        'type'              => 'file',
                        'instructions'      => '',
                        'required'          => 1,
                        'conditional_logic' => 0,
                        'wrapper'           => [
                            'width' => '100',
                        ],
                        'return_format'     => 'array',
                        'library'           => 'all',
                        'min_size'          => '',
                        'max_size'          => '',
                        'mime_types'        => '',
                    ],
                ],
                'location'              => [
                    [
                        [
                            'param'    => 'options_page',
                            'operator' => '==',
                            'value'    => 'sfcs-update-indicators',
                        ],
                    ],
                ],
                'menu_order'            => 0,
                'position'              => 'normal',
                'style'                 => 'default',
                'label_placement'       => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen'        => '',
                'active'                => true,
                'description'           => '',
            ]
        );
    }
}

add_action( 'init', 'register_custom_acf_fields_sub_settings_page' );