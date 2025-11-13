<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Apple ID API Configuration
    |--------------------------------------------------------------------------
    |
    | 配置主站 API 地址和访问令牌
    |
    */

    // API 基础地址
    'api_url' => env('APPLEID_API_URL', 'https://u.fast6.xyz/api/v2'),

    // 访问令牌（单个 Apple ID 的 token）
    'token' => env('APPLEID_TOKEN', ''),

    // HTTP 超时设置（秒）
    'timeout' => env('APPLEID_TIMEOUT', 10),

    // 连接超时设置（秒）
    'connect_timeout' => env('APPLEID_CONNECT_TIMEOUT', 5),
];
