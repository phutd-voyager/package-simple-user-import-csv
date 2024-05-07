<?php

return [
    'csv_reader' => [
        'limit_length' => 1000,
        'skip_header' => true,
        'header_format' => [
            0 => 'name',
            1 => 'email',
            2 => 'password',
        ],
    ],

    'user_validator' => [
        'rules' => [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ],
    ]
];
