<?php

return [
    'title' => 'Site',

    'model' => 'Keyhunter\Administrator\Model\Settings',

    'rules' => [
        'site::email'   => 'required|email',
        'site::phone' => 'required'
    ],

    'edit_fields' => [
        'site::email' => ['type' => 'email'],

        'site::phone' => ['type' => 'text'],

        'site::adress' => ['type' => 'text'],

        'site::map' => ['type' => 'text'],


    ]
];