<?php

use Illuminate\Contracts\Auth\Guard;
use App\Repositories\RolesRepository;

return [
    'prefix'          => 'admin',
    'title'           => 'Admin panel',
    'title_mini'      => 'AP',
    'auth_identity'   => 'email',
    'auth_credential' => 'password',
    'auth_conditions' => [
        'active' => 1,
        'role_id'   => function () {
            return (new RolesRepository)->getAdminRole()->id;
        }
    ],
    'auth_model'      => 'App\User',
    /**
     * The path to your model config directory
     *
     * @type string
     */
    'models_path'     => app('path.config') . '/administrator',
    /**
     * The path to your settings config directory
     *
     * @type string
     */
    'settings_path'   => app('path.config') . '/administrator/settings',
    'assets_path'     => 'administrator',
    /**
     * Basic user validation
     */
        'permission'      => function (Guard $user) {
            if($user->user()) {
                return (new RolesRepository)->getAdminRole()->id == $user->user()->role_id;
            }

            return ! ($user->guest());
    },
    /**
     * The menu item that should be used as the default landing page of the administrative section
     *
     * @type string
     */
    'home_page'       => 'admin/dashboard',
    /**
     * Default locale
     */
    'locale'          => 'en',
    'rows_per_page'   => 20,
    /**
     * Enable Admin Event subscriber
     */
    'subscriber'      => '\Keyhunter\Administrator\Subscriber\AdminSubscriber',
    'log_actions'     => false,

    'custom_field_types' => [
        // Here goes your custom types
        // 'test' => App\Administrator\Types\AjaxImageUpload::class
    ]
];