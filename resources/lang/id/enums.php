<?php

use App\Enums\PaymentProvider;
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
        PaymentType::ON_THE_SPOT => 'Pembayaran di Tempat (Sekolah)',
    ],

    PaymentProvider::class => [
        PaymentProvider::BCA => 'BCA',
        PaymentProvider::BNI => 'BNI',
        PaymentProvider::BRI => 'BRI',
        PaymentProvider::MANDIRI => 'Mandiri',
        PaymentProvider::CASH => 'Tunai',
    ],
];
