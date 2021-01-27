<?php

use App\Enums\PaymentProvider;
use App\Enums\PaymentType;
use App\Enums\Role;

return [
    Role::class => [
        Role::ADMIN => 'Administrator',
        Role::TEACHER => 'Teacher',
        Role::STUDENT => 'Student',
        Role::HEAD_MASTER => 'Head Master',
    ],

    PaymentType::class => [
        PaymentType::BANK_TRANSFER => 'Bank Transfer',
    ],

    PaymentProvider::class => [
        PaymentProvider::BCA => 'BCA',
        PaymentProvider::BNI => 'BNI',
        PaymentProvider::BRI => 'BRI',
        PaymentProvider::MANDIRI => 'Mandiri',
    ],
];
