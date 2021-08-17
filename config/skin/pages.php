<?php

return [
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

    // User Pages
    'user' => [
        'profile' => [
            'title' => 'User Profile',
        ],
    ],

    'teams' => [
        'create' => [
            'title'=> 'Create Team'
        ],
        '(\d+)' => [
            'title' => 'Team Settings',
        ]

        
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

];
