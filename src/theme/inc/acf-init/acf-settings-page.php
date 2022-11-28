<?php
/**
 * This function records fields for the acf.
 */
function register_custom_acf_fields_settings_page() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {

        $log_download_create_indicators = '<div id="content-download-csv-create"></div>';

        acf_add_local_field_group(
            [
                'key'                   => 'group_sfcs_settings_page',
                'title'                 => 'SFCS Options Page',
                'fields'                => [
                    [
                        'key'               => 'field_settings_tab_1',
                        'label'             => 'Download Template',
                        'name'              => 'settings_tab_1',
                        'type'              => 'tab',
                        'instructions'      => '',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'placement'         => 'top',
                    ],
                    [
                        'key'               => 'field_download_create_indicators',
                        'name'              => 'download_create_indicators',
                        'type'              => 'message',
                        'instructions'      => '',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'message'           => $log_download_create_indicators,
                        'esc_html'          => 0,
                        'wrapper'           => [
                            'width' => '100',
                            'class' => '',
                            'id'    => 'download-create-indicators',
                        ],
                    ],
                    [
                        'key'               => 'field_settings_tab_2',
                        'label'             => 'Create indicators',
                        'name'              => 'settings_tab_2',
                        'type'              => 'tab',
                        'instructions'      => '',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'placement'         => 'top',
                    ],
                    [
                        'key'               => 'field_indicator_country',
                        'label'             => 'Indicator Country',
                        'name'              => 'indicator_country',
                        'aria-label'        => '',
                        'type'              => 'select',
                        'instructions'      => '',
                        'required'          => 1,
                        'conditional_logic' => 0,
                        'wrapper'           => [
                            'width' => '50',
                        ],
                        'choices'           => array(),
                        'default_value'     => false,
                        'return_format'     => 'value',
                        'multiple'          => 0,
                        'allow_null'        => 0,
                        'ui'                => 1,
                        'ajax'              => 1,
                        'placeholder'       => '',
                    ],
                    [
                        'key'               => 'field_import_csv_indicators',
                        'label'             => 'Import CSV',
                        'name'              => 'import_csv_indicators',
                        'aria-label'        => '',
                        'type'              => 'file',
                        'instructions'      => '',
                        'required'          => 1,
                        'conditional_logic' => 0,
                        'wrapper'           => [
                            'width' => '50',
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
                            'value'    => 'sfcs-theme-general-settings',
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

add_action( 'init', 'register_custom_acf_fields_settings_page' );