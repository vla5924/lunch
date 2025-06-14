<?php

return [
    // AdminSeeder
    'admin_tg_id' => env('ADMIN_TG_ID'),
    'admin_tg_name' => env('ADMIN_TG_NAME', 'admin'),
    'admin_tg_username' => env('ADMIN_TG_USERNAME', 'admin'),
    'admin_yandex_id' => env('ADMIN_YANDEX_ID'),

    'fallback_avatar' => env('USER_FALLBACK_AVATAR'),

    'url_scheme' => env('APP_URL_SCHEME', 'http'),

    'yandex_metrika_id' => env('YANDEX_METRIKA_ID'),
];
