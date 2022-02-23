<?php

if (! function_exists('roles')) {
    function roles()
    {
        $roles = [
            'owner' => 'Owner',
            'fb'    => 'Full (with Billing)',
            'fnb'   => 'Full (without Billing)',
            'pb'    => 'Partial (with Billing)',
            'pnb'   => 'Partial (without Billing)',
        ];

        return $roles;
    }
}
