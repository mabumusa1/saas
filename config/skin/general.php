<?php

return [
    // Meta
    'meta'    => [
        'description' => 'Steer Campaign provides managed Mautic hosting for agencies, marketers, and corporate. Mautic support, security and performance.',
        'keywords'    => 'Mautic support, Mautic Hosting, Marketing Automation, Open Source, manged mautic hosting',
        'canonical'   => 'https://steercampaign.com',
    ],
    // General
    'general' => [
        'terms' => 'https://steercampaign.com/terms-of-service',
        'privacy' => 'https://steercampaign.com/privacy',
    ],

    // Assets
    'assets' => [
        'favicon' => 'media/logos/favicon.ico',
        'fonts'   => [
            'google' => [
                'Varela:300,400,500,600,700',
            ],
        ],
        'css'     => [
            'plugins/global/plugins.bundle.css',
            'plugins/global/plugins-custom.bundle.css',
            'plugins/custom/datatables/datatables.bundle.css',
            'css/style.bundle.css',
        ],
        'js'      => [
            'plugins/global/plugins.bundle.js',
            'js/scripts.bundle.js',
            'plugins/custom/datatables/datatables.bundle.js',
        ],
    ],

    // Layout
    'skin' => [
        // Main
        'main'       => [
            'base'              => 'default', // Set base layout: default|docs
            'type'              => 'default', // Set layout type: default|blank|none
            'dark-mode-enabled' => true, // Enable optioanl dark mode mode
            'primary-color'     => '#009EF7',
        ],

        // Docs
        'docs'       => [
            'logo-path'  => [
                'default' => 'logos/logo-1-dark.svg',
                'dark'    => 'logos/logo-1.svg',
            ],
            'logo-class' => 'h-15px',
        ],

        // Loader
        'loader'     => [
            'display' => false,
            'type'    => 'default', // Set default|spinner-message|spinner-logo to hide or show page loader
        ],

        // Header
        'header'     => [
            'display'   => true, // Display header
            'width'     => 'fluid', // Set header width(fixed|fluid)
            'left'      => 'page-title', // Set left part content(menu|page-title)
            'fixed'     => [
                'desktop'           => true,  // Set fixed header for desktop
                'tablet-and-mobile' => true, // Set fixed header for talet & mobile
            ],
            'menu-icon' => 'svg', // Menu icon type(svg|font)
        ],

        // Toolbar
        'toolbar'    => [
            'display' => true, // Display toolbar
            'width'   => 'fluid', // Set toolbar container width(fluid|fixed)
            'fixed'   => [
                'desktop'           => true,  // Set fixed header for desktop
                'tablet-and-mobile' => false, // Set fixed header for talet & mobile
            ],
            'layout'  => 'toolbar-1', // Set toolbar type
            'layouts' => [
                'toolbar-1' => [
                    'height'                   => '55px',
                    'height-tablet-and-mobile' => '55px',
                ],
            ],
        ],

        // Page title
        'page-title' => [
            'display'               => false, // Display page title
            'breadcrumb'            => false, // Display breadcrumb
            'description'           => false, // Display description
            'layout'                => 'select', // Set layout(default|select)
            'direction'             => 'row', // Flex direction(column|row))
            'responsive'            => true, // Move page title to cotnent on mobile mode
            'responsive-breakpoint' => 'lg', // Responsive breakpoint value(e.g: md, lg, or 300px)
            'responsive-target'     => '#kt_toolbar_container', // Responsive target selector
        ],

        // Aside
        'aside'      => [
            'display'   => true, // Display aside
            'theme'     => 'dark', // Set aside theme(dark|light)
            'menu'      => 'main', // Set aside menu(main|documentation)
            'fixed'     => true,  // Enable aside fixed mode
            'minimized' => false, // Set aside minimized by default
            'minimize'  => false, // Allow aside minimize toggle
            'hoverable' => false, // Allow aside hovering when minimized
            'menu-icon' => 'svg', // Menu icon type(svg|font)
        ],

        // Content
        'content'    => [
            'width'  => 'fixed', // Set content width(fixed|fluid)
            'skin' => 'default',  // Set content layout(default|documentation)
        ],

        // Footer
        'footer'     => [
            'width' => 'fluid', // Set fixed|fluid to change width type
        ],

        // Scrolltop
        'scrolltop'  => [
            'display' => true, // Display scrolltop
        ],
    ],
];
