<?php
function adminNav(){
    return [
        /*
        |--------------------------------------------------------------------------
        | Admin Navigation Menu
        |--------------------------------------------------------------------------
        |
        | This array is for Navigation menus of the backend.  Just add/edit or
        | remove the elements from this array which will automatically change the
        | navigation.
        |
        */
        // SIDEBAR LAYOUT - MENU
        [
            'title'  => 'Instruction',
            'link'   => route('setup.steps'),
            'active' => (Request::is('setup*'))?'active':'',
        ],
        [
            'title'  => 'Dashboard',
            'link'   => route('home'),
            'active' => (Request::path() == '/')?'active':'',
        ],
        [
            'title'  => 'Ruleset',
            'link'   => route('offers.index'),
            'active' => (Request::is('offers*'))?'active':'',
        ],
        [
            'title'  => 'Display Settings',
            'link'   => route('settings.index'),
            'active' => (Request::is('settings*'))?'active':'',
        ],
        [
            'title'  => 'Help',
            'link'   => '#',
            'active' => (Request::is('setup/uninstall/view*'))?'active':'',
            'child' => [
                [
                    'title'  => 'Uninstall',
                    'link'   => route('setup.uninstall.view'),
                    'active' => (Request::is('setup/uninstall/view'))?'active':'',
                    'target' => '',
                ],
                [
                    'title'  => 'Faq',
                    'link'   => route('faq'),
                    'active' => '',
                    'target' => '',
                ],
                [
                    'title'  => 'Instruction',
                    'link'   => route('instruction'),
                    'active' => '',
                    'target' => '',
                ],
            ]
        ],
    ];
}
