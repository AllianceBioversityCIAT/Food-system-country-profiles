<?php
/**
 * This function records fields for the acf.
 */
function register_custom_acf_fields_settings_page() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {

        $log_download_create_indicators = '<div id="conent-download-csv-create"></div>';

        acf_add_local_field_group(
            [
                'key'                   => 'group_sfcs_settings_page',
                'title'                 => 'SFCS Options Page',
                'fields'                => [
                    [
                        'key'               => 'field_settings_tab_1',
                        'label'             => 'Create indicators',
                        'name'              => '',
                        'type'              => 'tab',
                        'instructions'      => '',
                        'required'          => 0,
                        'conditional_logic' => 0,
                        'placement'         => 'top',
                        'endpoint'          => 1,
                    ],
                    [
                        'key'               => 'field_download_create_indicators',
                        'name'              => '',
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