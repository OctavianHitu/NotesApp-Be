<?php

namespace App\Helpers;

use Firebase\JWT\JWT;

class JwtHelper
{
    public static function generateJwt($payload)
    {
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}