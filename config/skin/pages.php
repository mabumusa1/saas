<?php

return [
    'user' => [
        'profile' => [
            'title' => 'User Profile',
        ],
    ],
    'index' => [
        'title'       => 'Dashboard',
        'description' => '',
        'view'        => 'index',
        'skin'      => [
            'page-title' => [
                'description' => true,
                'breadcrumb'  => false,
            ],
        ],
        'assets'      => [
            'custom' => [
                'js' => [
                    'js/custom/widgets.js',
                ],
            ],
        ],
    ],

    'login'           => [
        'title'  => 'Login',
        'assets' => [
            'custom' => [
                'js' => [
                    'js/custom/authentication/sign-in/general.js',
                ],
            ],
        ],
    ],
    'register'        => [
        'title'  => 'Register',
        'assets' => [
            'custom' => [
                'js' => [
                    'js/custom/authentication/sign-up/general.js',
                ],
            ],
        ],
    ],
    'forgot-password' => [
        'title'  => 'Forgot Password',
        'assets' => [
            'custom' => [
                'js' => [
                    'js/custom/authentication/password-reset/password-reset.js',
                ],
            ],
        ],
    ],

    'log' => [
        'audit'  => [
            'title'  => 'Audit Log',
            'assets' => [
                'custom' => [
                    'css' => [
                        'plugins/custom/datatables/datatables.bundle.css',
                    ],
                    'js'  => [
                        'plugins/custom/datatables/datatables.bundle.js',
                    ],
                ],
            ],
        ],
        'system' => [
            'title'  => 'System Log',
            'assets' => [
                'custom' => [
                    'css' => [
                        'plugins/custom/datatables/datatables.bundle.css',
                    ],
                    'js'  => [
                        'plugins/custom/datatables/datatables.bundle.js',
                    ],
                ],
            ],
        ],
    ],

    'account'       => [
        'overview' => [
            'title'  => 'Account Overview',
            'view'   => 'account/overview/overview',
            'assets' => [
                'custom' => [
                    'js' => [
                        'js/custom/widgets.js',
                    ],
                ],
            ],
        ],

        'settings' => [
            'title'  => 'Account Settings',
            'view'   => 'account/settings/settings',
            'assets' => [
                'custom' => [
                    'js' => [
                        'js/custom/account/settings/profile-details.js',
                        'js/custom/account/settings/signin-methods.js',
                        'js/custom/modals/two-factor-authentication.js',
                    ],
                ],
            ],
        ],
    ],

];
