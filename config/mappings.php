<?php

use App\Entities\Customer;

return [
    Customer::class => [
        'type' => 'entity',
        'table' => 'customers',
        'id' => [
            'id' => [
                'type' => 'uuid',
            ]
        ],
        'fields' => [
            'firstName' => [
                'type' => 'string',
                'column' => 'first_name',
            ],
            'lastName' => [
                'type' => 'string',
                'column' => 'last_name',
            ],
            'email' => [
                'type' => 'string',
            ],
            'username' => [
                'type' => 'string'
            ],
            'password' => [
                'type' => 'string',
            ],
            'gender' => [
                'type' => 'string',
            ],
            'country' => [
                'type' => 'string',
            ],
            'city' => [
                'type' => 'string'
            ],
            'phone' => [
                'type' => 'string',
            ],
        ],
    ],
];
