<?php

declare(strict_types=1);

return [
    /**
     * Bot configuration
     */
    'bot'      => [
        'name'    => env('PHP_TELEGRAM_BOT_NAME', ''),
        'api_key' => env('PHP_TELEGRAM_BOT_API_KEY', ''),
    ],

    /**
     * Database integration
     */
    'database' => [
        'enabled'    => false,
        'connection' => env('DB_CONNECTION', 'mysql'),
    ],

    'commands' => [
        'before'  => true,
        'paths'   => [
            __DIR__ . '/../app/Telegram/Commands/'
        ],
        'configs' => [
            // Custom commands configs
        ],
    ],

    'admins'  => [
        // Admin ids
    ],

    /**
     * Request limiter
     */
    'limiter' => [
        'enabled'  => false,
        'interval' => 1,
    ],

    'tab_black_list' => env('PHP_TELEGRAM_TAG_BLACK_LIST', ''),
    'upload_path'   => '',
    'download_path' => '',
];
