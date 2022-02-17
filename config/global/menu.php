<?php

return [
    // Main menu
    'main'          => [
        //// Dashboard
        [
            'title' => 'Dashboard',
            'path'  => '',
            'icon'  => theme()->getSvgIcon('skin/media/icons/duotune/art/art002.svg', 'svg-icon-2'),
        ],

        [
            'title' => 'Sites',
            'path'  => 'sites',
            'icon'  => theme()->getSvgIcon('skin/media/icons/duotune/art/art003.svg', 'svg-icon-2'),
        ],

        // Users
        [
            'title'      => 'Users',
            'icon'       => [
                'svg'  => theme()->getSvgIcon('skin/media/icons/duotune/communication/com006.svg', 'svg-icon-2'),
                'font' => '<i class="bi bi-person fs-2"></i>',
            ],
            'classes'    => ['item' => 'menu-accordion'],
            'attributes' => [
                'data-kt-menu-trigger' => 'click',
            ],
            'sub'        => [
                'class' => 'menu-sub-accordion menu-active-bg',
                'items' => [
                    [
                        'title'  => 'Account Users',
                        'path'   => 'users',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ],
                    [
                        'title'  => 'Techincal Contacts',
                        'path'   => 'techincal_contacts',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ],
                    [
                        'title'  => 'Activity Log',
                        'path'   => 'activity_log',
                        'bullet' => '<span class="bullet bullet-dot"></span>',
                    ],

                ],
            ],
        ],

    ],

    // Horizontal menu
    'horizontal'    => [],
];
