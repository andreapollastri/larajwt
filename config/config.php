<?php

return [
    'jwt_session_db_check' => env('JWT_TOKEN_SESSION_DB_CHECK', false),
    'jwt_access_secret' => env('JWT_ACCESS_TOKEN_SECRET_KEY'),
    'jwt_refresh_secret' => env('JWT_REFRESH_TOKEN_SECRET_KEY'),
    'jwt_access_ttl' => env('JWT_ACCESS_TOKEN_TTL', 900),
    'jwt_refresh_ttl' => env('JWT_REFRESH_TOKEN_TTL', 7200)
];
