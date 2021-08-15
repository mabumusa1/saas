<?php

return [
    // Meta
    'meta'    => [
        'title'       => 'Metronic Bootstrap 5 Theme',
        'description' => 'Metronic admin dashboard live demo. Check out all the features of the admin panel. A large number of settings, additional services and widgets.',
        'keywords'    => 'Metronic, bootstrap, bootstrap 5, Angular 11, VueJs, React, Laravel, admin themes, web design, figma, web development, ree admin themes, bootstrap admin, bootstrap dashboard',
        'canonical'   => 'https://preview.keenthemes.com/metronic8',
    ],
    // General
    'general' => [
        'website'             => 'https://keenthemes.com',
        'about'               => 'https://keenthemes.com',
        'contact'             => 'mailto:support@keenthemes.com',
        'support'             => 'https://keenthemes.com/support',
        'bootstrap-docs-link' => 'https://getbootstrap.com/docs/5.0',
        'licenses'            => 'https://keenthemes.com/licensing',
        'social-accounts'     => [
            [
                'name' => 'Youtube', 'url' => 'https://www.youtube.com/c/KeenThemesTuts/videos', 'logo' => 'svg/social-logos/youtube.svg', 'class' => 'h-20px',
            ],
            [
                'name' => 'Github', 'url' => 'https://github.com/KeenthemesHub', 'logo' => 'svg/social-logos/github.svg', 'class' => 'h-20px',
            ],
            [
                'name' => 'Twitter', 'url' => 'https://twitter.com/keenthemes', 'logo' => 'svg/social-logos/twitter.svg', 'class' => 'h-20px',
            ],
            [
                'name' => 'Instagram', 'url' => 'https://www.instagram.com/keenthemes', 'logo' => 'svg/social-logos/instagram.svg', 'class' => 'h-20px',
            ],

            [
                'name' => 'Facebook', 'url' => 'https://www.facebook.com/keenthemes', 'logo' => 'svg/social-logos/facebook.svg', 'class' => 'h-20px',
            ],
            [
                'name' => 'Dribbble', 'url' => 'https://dribbble.com/keenthemes', 'logo' => 'svg/social-logos/dribbble.svg', 'class' => 'h-20px',
            ],
        ],
    ],

    // Assets
    'assets' => [
        'favicon' => 'media/logos/favicon.ico',
        'fonts'   => [
            'google' => [
                'Poppins:300,400,500,600,700',
            ],
        ],
        'css'     => [
            'plugins/global/plugins.bundle.css',
            'plugins/global/plugins-custom.bundle.css',
            'css/style.bundle.css',
        ],
        'js'      => [
            'plugins/global/plugins.bundle.js',
            'js/scripts.bundle.js',
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
            'left'      => 'menu', // Set left part content(menu|page-title)
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
            'display'               => true, // Display page title
            'breadcrumb'            => true, // Display breadcrumb
            'description'           => false, // Display description
            'skin'                => 'default', // Set layout(default|select)
            'direction'             => 'row', // Flex direction(column|row))
            'responsive'            => true, // Move page title to cotnent on mobile mode
            'responsive-breakpoint' => 'lg', // Responsive breakpoint value(e.g: md, lg, or 300px)
            'responsive-target'     => '#kt_toolbar_container', // Responsive target selector
        ],

        // Aside
        'aside'      => [
            'display'   => true, // Display aside
            'theme'     => 'light', // Set aside theme(dark|light)
            'menu'      => 'main', // Set aside menu(main|documentation)
            'fixed'     => true,  // Enable aside fixed mode
            'minimized' => false, // Set aside minimized by default
            'minimize'  => false, // Allow aside minimize toggle
            'hoverable' => true, // Allow aside hovering when minimized
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
