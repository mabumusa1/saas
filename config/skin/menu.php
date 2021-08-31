<?php

use App\Core\Adapters\Theme;

Theme::$demo = 'skin';

return [
    // Refer to config/global/menu.php

    // Main menu
    'main'          => [
        //// Dashboard
        [
            'title' => 'Sites',
            'path'  => 'sites',
            'icon'  => theme()->getSvgIcon('icons/duotone/Design/PenAndRuller.svg', 'svg-icon-2'),
            'icon'  => theme()->getSvgIcon('icons/duotone/Layout/Layout-008.svg', 'svg-icon-2x'),
        ],
        [
            'title' => 'Users',
            'path'  => 'users',
            'icon'  => theme()->getSvgIcon('icons/duotone/Design/PenAndRuller.svg', 'svg-icon-2'),
            'icon'  => theme()->getSvgIcon('icons/duotone/Communication/users.svg', 'svg-icon-2x'),
        ],
        [
            'title' => 'Billing',
            'path'  => 'billing',
            'icon'  => theme()->getSvgIcon('icons/duotone/Design/PenAndRuller.svg', 'svg-icon-2'),
            'icon'  => theme()->getSvgIcon('icons/duotone/Finance/fin-008.svg', 'svg-icon-2x'),
        ],

    ],

    // Horizontal menu
    'horizontal'    => [],
];
