<?php

use NioModules\WdPaypal\WdPaypalModule;

return [
    WdPaypalModule::SLUG => [
        'name' => __('CryptoWallet'),
        'slug' => WdPaypalModule::SLUG,
        'method' => WdPaypalModule::METHOD,
        'account' => __('CryptoWallet'),
        'icon' => 'ni-wallet-fill',
        'full_icon' => 'ni-wallet-fill',
        'is_online' => false,
        'processor_type' => 'withdraw',
        'processor' => WdPaypalModule::class,
        'supported_currency' => [
            'USD', 'BTC', 'ETH', 'LTC', 'BCH', 'BNB', 'USDC', 'USDT', 'TRX'
        ],
        'system' => [
            'kind' => 'Withdraw',
            'info' => 'Gateway / Offline',
            'type' => WdPaypalModule::MOD_TYPES,
            'version' => WdPaypalModule::VERSION,
            'update' => WdPaypalModule::LAST_UPDATE,
            'description' => 'Manage withdraw funds manually using cryptowallet.',
            'addons' => false,
        ]
    ],
];
