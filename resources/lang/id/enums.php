<?php

use App\Enums\PaymentType;
use App\Enums\Role;

return [
    Role::class => [
        Role::ADMIN => 'Administrator',
        Role::TEACHER => 'Asatidz',
        Role::STUDENT => 'Santri',
        Role::HEAD_MASTER => 'Kepala Sekolah',
    ],

    PaymentType::class => [
        PaymentType::BANK_TRANSFER => 'Transfer Bank',
    ],
];
