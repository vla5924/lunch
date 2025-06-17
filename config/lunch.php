<?php

return [
    // AdminSeeder
    'admin_id' => env('ADMIN_ID', 1),
    'admin_tg_id' => env('ADMIN_TG_ID'),
    'admin_tg_name' => env('ADMIN_TG_NAME', 'admin'),
    'admin_tg_username' => env('ADMIN_TG_USERNAME', 'admin'),
    'admin_yandex_id' => env('ADMIN_YANDEX_ID'),

    'fallback_avatar' => env('USER_FALLBACK_AVATAR'),

    'restaurant_ban_limit' => (int) env('RESTAURANT_BAN_LIMIT', 5),

    'url_scheme' => env('APP_URL_SCHEME', 'http'),

    'yandex_metrika_id' => env('YANDEX_METRIKA_ID'),
];
